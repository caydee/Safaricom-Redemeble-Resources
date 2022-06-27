<?php

namespace App\Jobs;

use App\Models\Batch;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateVouchers implements ShouldQueue
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
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $companyid = $this->data->companyid;
        $count = $this->data->count;
        $batchno = $this->data->batchno;
        $productid = $this->data->productid;
        $status = true;

        DB::transaction(
            function () use($companyid,$productid,$count,$batchno,&$status){
                $units = \App\Models\OrgUnits::lockForUpdate()->where('organization_id',$companyid)->where('product_id',$productid)->limit(1)->first();
                if(is_null($units))
                {
                    $status = false;
                    return;
                }

                if($units->units < $count)
                {
                    $status = false;
                    return;
                }

                for($i=0;$i<$count;$i++)
                {
                    $data = [];
                    $data['voucher'] = Str::uuid()->toString();
                    $data['batch_id'] = $batchno;
                    $data['product_id'] = $productid;
                    $data['organization_id']= $companyid;
                    $data['active'] = 1;
                    $voucher = new Voucher($data);
                    $voucher->save();
                }
                $units->units = ($units->units - $count);
                $units->save();
                $batch = Batch::find($batchno);
                if(!is_null($batch))
                {
                    $batch->status = 1;
                    $batch->save();
                }
            }
        );
    }
}
