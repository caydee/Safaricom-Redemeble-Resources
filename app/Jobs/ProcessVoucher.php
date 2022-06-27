<?php

namespace App\Jobs;

use App\Models\OrgProduct;
use App\Models\UnitUsage;
use App\Models\Voucher;
use App\Utils\Data;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessVoucher implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        public $sms;
        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($sms)
            {
                $this->sms  =   $sms;
            }

        /**
         * Execute the job.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function handle()
            {
                $id     =   substr($this->sms->message,9);
                $vou    =   substr($this->sms->message,1,8);
                $v      =   Voucher::find($id);

                if(!is_null($v))
                    {

                        if(substr($v->voucher,0,8) == strtolower($vou) )
                            {
                                if($v->active == 1)
                                    {

                                        $request = new Request();
                                        $request->request->add(['msisdn'=>$this->sms->msisdn,
                                            'description'=>$v->product->sender_name]);
                                        $request->setMethod('post');

                                        $check = Data::redemption($request);
                                        if($check->responseStatus === "1000")
                                            {

                                                DB::transaction(
                                                    function() use($v)
                                                    {
                                                        $voucher    =   Voucher::lockForUpdate()
                                                            ->find($v->id);
                                                        $voucher->active   =   0;
                                                        $voucher->save();
                                                        $orgprod    =   OrgProduct::where('product_id',$v->product_id)
                                                            ->where('organization_id',$v->organization_id)
                                                            ->first();
                                                        if(!is_null($orgprod))
                                                            {
                                                            UnitUsage::insert([["msisdn"=>$this->sms->msisdn,'content'=>"Voucher : "
                                                                .substr($v->voucher,0,8),"org_product_id"=>$orgprod->id??0,'status'=>1]]);
                                                            }

                                                    });
                                            }
                                    }
                                else
                                    {
                                        return response()->json(['status'=>0,'msg'=>'Voucher  already used']);
                                    }

                            }
                    }
            }
    }
