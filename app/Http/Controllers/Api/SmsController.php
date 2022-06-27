<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessVoucher;
use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
    {
        public function receive(Request $request)
            {
               $data = $request->all();

               $processed   =   self::process_array($data["requestParam"]['data']);
               if($data["operation"] === "CP_NOTIFICATION")
                   {
                        $sms                        =   new Sms();
                        $sms->msisdn                =   $processed["Msisdn"];
                        $sms->message               =   $processed["USER_DATA"];
                        $sms->link_id               =   $processed["LinkId"];
                        $sms->offercode             =   $processed["OfferCode"];
                        $sms->type                  =   $processed["Type"];
                        $sms->referenceid           =   $processed["RefernceId"];
                        $sms->client_transaction_id =   $processed["ClientTransactionId"];
                        $res                        =   $sms->save();
                        if($res)
                            {
                                ProcessVoucher::dispatch($sms);
                                Log::info("sms".json_encode($sms));
                            }

                        else
                            Log::error("Failed to save message",$processed);

                   }

            }
    }
