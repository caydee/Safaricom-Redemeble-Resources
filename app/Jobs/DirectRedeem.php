<?php

namespace App\Jobs;

use App\Models\OrgProduct;
use App\Models\OrgUnits;
use App\Models\UnitUsage;
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

class DirectRedeem implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public $data;
        public function __construct($data)
            {
                $this->data =   $data;
            }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
            {
                $request = new Request();
                $request->request->add(['msisdn'=>$this->data->msisdn,'description'=>$this->data->sender_name]);
                $request->setMethod('post');
                $check  =   Data::redemption($request);

                if($check->responseStatus === "1000")
                    {

                        DB::transaction(
                            function()
                                {
                                    $orgunits   =   OrgUnits::lockForUpdate()
                                                            ->where('organization_id',$this->data->organization_id)
                                                            ->where('product_id',$this->data->product_id)
                                                            ->first();
                                    $orgunits->update(['units'=>$orgunits->units - 1]);
                                    $orgprod    =   OrgProduct::where('product_id',$this->data->product_id)
                                                                ->where('organization_id',$this->data->organization_id)
                                                                ->first();
                                    if(!is_null($orgprod))
                                        {
                                            UnitUsage::insert([["msisdn"=>$this->data->msisdn,'content'=>"API REQUEST","org_product_id"=>$orgprod->id??0,'status'=>1]]);
                                        }

                                }
                        );
                    }
            }
    }
