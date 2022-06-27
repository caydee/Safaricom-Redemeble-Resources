<?php
namespace App\Utils;

use App\Constants\DataParameters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Validator\Constraints\Uuid;


class Data
    {
        public static function get_token()
            {
                $credentials    =   base64_encode(DataParameters::consumerkey.':'.DataParameters::consumersecret);
               // Log::info('credentials'.$credentials);
                $data           =   Http::withHeaders(['Content-Type'=>'application/json','Authorization'=>'Basic '.$credentials])
                                        ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                                        ->get('https://api.safaricom.co.ke/'.DataParameters::TokenUrl);
                //
                //Log::error($data->clientError());
                if($data->successful())
                    {
                        //Log::error("ded",(array)$data->object());
                        return $data->object();
                    }
            }
        public static function get_data(Request $request)
            {
                $data = Http::withHeaders([
                                            "SourceSystem"=>"APIGEE",
                                            "Content-Type"=>"application/json",
                                            "Accept-Language"=>"EN",
                                            "X-Source-CountryCode"=>"KE",
                                            "X-Source-Operator"=>"Safaricom",
                                            "X-Source-Division"=>"Consumer",
                                            "X-Source-System"=>"APG",
                                            "X-Source-Timestamp"=>Carbon::now('Africa/Nairobi')->getTimestamp(),
                                            "X-Source-Identity-Token-0"=>"OAuth",
                                            "X-MessageID"=>Uuid::generate()->string,
                                            "Accept-Encoding"=>"application/json"
                                        ])
                            ->withToken(self::get_token()->access_token)
                            ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                            ->post(DataParameters::DataUrl, [ "ReqHeader" => (object)[ "SourceSystem" => "APIGEE" , "pin" => DataParameters::UserName , "password" => DataParameters::Password ] , "ReqBody" => (object)[ "MSISDN" => $request->msisdn , "SendSMS" => $request->sendsms , "ResourceType" => $request->resourcetype , "AccountType" => $request->accounttype , "ExpiryPeriod" => $request->expiry , "RedemptionValue" => $request->redemptionval , "MoreInfo" => $request->moreinfo ] ]);
                if($data->successful())
                    {
                        Log::error("ded",(array)$data->object());
                        return $data->object();
                    }
            }
        public static function redemption(Request $request)
            {
                //dd($request->description);
                //Log::info("Access token : ".self::get_token()->access_token);
                $data = Http::withHeaders(["Content-Type" =>"application/json"])
                            ->withToken(self::get_token()->access_token,'Bearer')
                            ->withOptions(['verify' => app_path("Resources/cacert.pem") , 'http_errors' => FALSE])
                            ->post(DataParameters::saf_link().DataParameters::RedemptionUrl, [ "id" => substr
                            ($request->msisdn,-9) , "description" => $request->description , "pin" => DataParameters::UserName ,
                                "password" => DataParameters::Password
                            ]);
                if($data->successful())
                    {
                        Log::error("ded",(array)$data->object());
                        return $data->object();
                    }
            }
        public static function balance(Request $request)
            {
                $data = Http::withHeaders(["Content-Type" =>"application/json"])
                            ->withToken(self::get_token()->access_token)
                            ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                            ->post(DataParameters::saf_link().DataParameters::BalanceUrl, [ "id" => substr
                            ($request->msisdn , -9) , "description" => $request->description , "pin" => DataParameters::UserName
                                , "password" => DataParameters::Password ]);
                if($data->successful())
                    {
                        //Log::error("ded",(array)$data->object());
                        return $data->object();
                    }
            }
    }
