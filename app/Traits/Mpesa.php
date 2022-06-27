<?php
namespace App\Traits;

use App\Constants\MpesaParameters;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait Mpesa
    {

        /**
         * @return object|void
         */
        public static function generatetoken()
            {
                $credentials    =   base64_encode(MpesaParameters::consumerkey.':'.MpesaParameters::consumersecret);
                $data           =   Http::withHeaders(['Content-Type'=>'application/json','Authorization'=>'Basic '.$credentials])
                                            ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                            ->get(MpesaParameters::link().MpesaParameters::token_link);

                if($data->successful())
                    {
                        //Log::error("ded",(array)$data->object());
                        return $data->object();
                    }


            }

        /**
         * @param $plaintext
         * @return string
         */
        public static function cert($plaintext)
            {
                $cert       =   MpesaParameters::cert();
                $fp         =   fopen($cert,"r");
                $publicKey  =   fread($fp,filesize($cert));
                fclose($fp);
                openssl_get_publickey($publicKey);
                openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
                return  base64_encode($encrypted);
            }

        /**
         * @param $type
         * @return int
         */
        public static function getIdentifier($type="shortcode")
            {
                $type=strtolower($type);
                switch($type)
                    {
                        case "msisdn":
                                        $x = 1;
                                        break;
                        case "tillnumber":
                                        $x = 2;
                                        break;
                        case "shortcode":
                                        $x = 4;
                                        break;
                        default:
                                        $x =    4;
                    }
                return $x;
            }

        /**
         * @param $request
         * @return object|void
         */
        public static function checkout($request)
            {
                $timestamp 	=	date('YmdHis');
                $password 	=	base64_encode($request['shortcode'].$request['passkey'].$timestamp);
                $type       =   ($request['type'] == 'TILL')?'CustomerBuyGoodsOnline':'CustomerPayBillOnline';
                $till       =   ($request['type'] == 'TILL')?$request['cshortcode']:$request['shortcode'];
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::checkout_processlink, [ 'BusinessShortCode' => $request[ 'shortcode' ] , 'Password' => $password , 'Timestamp' => $timestamp , 'TransactionType' => $type , 'Amount' => $request[ 'amount' ] , 'PartyA' => $request[ 'msisdn' ] , 'PartyB' => $till , 'PhoneNumber' => $request[ 'msisdn' ] , 'CallBackURL' => MpesaParameters::stkrequestcallback() , 'AccountReference' => $request[ 'ref' ] , 'TransactionDesc' => $request[ 'desc' ] ]);

                if($data->successful())
                    {
                        return $data->object();
                    }
            }

        /**
         * @param $request
         *
         * @return object
         */
        public static function checkout_query($request)
            {
                $timestamp 	=	date('YmdHis');
                $password 	=	base64_encode($request['$shortcode'].$request['passkey'].$timestamp);
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::checkout_querylink, [ 'BusinessShortCode' => $request[ 'shortcode' ] , 'Password' => $password , 'Timestamp' => $timestamp , 'CheckoutRequestID' => $request[ 'CheckoutRequestID' ] ]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }

        /**
         * @param $request
         * @return object|void
         */
        public static function reversal($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::reversal_link, [ 'Initiator' => $request[ 'initiator' ] , 'SecurityCredential' => self::cert($request[ 'credential' ]) , 'CommandID' => 'TransactionReversal' , 'TransactionID' => $request[ 'TransID' ] , 'Amount' => $request[ 'amount' ] , 'ReceiverParty' => $request[ 'receiver' ] , 'RecieverIdentifierType' => self::getIdentifier($request[ 'receiverType' ]) , 'ResultURL' => MpesaParameters::reversalURL() , 'QueueTimeOutURL' => MpesaParameters::reversalURL() , 'Remarks' => $request[ 'remarks' ] , 'Occasion' => $request[ 'ocassion' ] ]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }

        /**
         * @param $request
         * @return object|void
         */
        public static function accountbalance($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken($request)->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::balance_link, [ 'Initiator' => $request[ 'initiator' ] , 'SecurityCredential' => self::cert($request[ 'credential' ]) , 'CommandID' => 'AccountBalance' , 'PartyA' => $request[ 'shortcode' ] , 'IdentifierType' => self::getIdentifier("Shortcode") , 'Remarks' => $request[ 'remark' ] , 'QueueTimeOutURL' => MpesaParameters::accountbalcallback() , 'ResultURL' => MpesaParameters::accountbalcallback() ]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }

        /**
         * @param $request
         * @param string $status
         * @return object|void
         */
        public static function c2b_register($status='Completed')
            {
                if(!empty($key= self::generatetoken()))
                    {

                        $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                            ->withOptions(['verify' => false,'debug' => false, 'http_errors' => false])
                                            ->withToken($key->access_token)
                                            ->post(MpesaParameters::link().MpesaParameters::c2b_regiterUrl, ['ShortCode' => '520530',
                                                'ResponseType' => $status,
                                                'ConfirmationURL' => MpesaParameters::c2bconfirmationcallback(),
                                                'ValidationURL' => MpesaParameters::c2bvalidationcallback()]);
                        //Log::error($data->clientError());
//                        if($data->successful())
//                            {
                                return $data->json();
//                            }
                    }
                //Log::error("failed");

            }

        /**
         * @param $request
         * @return object|void
         */
        public static function C2B($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::transtat_link, [ "ShortCode" => $request[ 'shortcode' ] , "CommandID" => "CustomerPayBillOnline" , "Amount" => $request[ 'amount' ] , "Msisdn" => $request[ 'msisdn' ] , "BillRefNumber" => $request[ 'ref' ] ]);
                if($data->successful())
                    {
                        return $data->object();
                    }

            }

        /**
         * @param $request
         * @return object|void
         */
        public static function B2B($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::b2b_link, [ 'Initiator' => $request[ 'initiator' ] ,
                                        'SecurityCredential' => self::cert($request[ 'credential' ]) , 'CommandID' =>
                                            $request[ 'CommandID' ] , 'SenderIdentifierType' => self::getIdentifier("shortcode") , 'RecieverIdentifierType' => self::getIdentifier("shortcode") , 'Amount' => $request[ 'amount' ] , 'PartyA' => $request[ 'partyA_shortcode' ] , 'PartyB' => $request[ 'partyB_shortcode' ] , 'AccountReference' => $request[ 'accountref' ] , 'Remarks' => $request[ 'remarks' ] , 'QueueTimeOutURL' => MpesaParameters::b2bcallback() , 'ResultURL' => MpesaParameters::b2bcallback() ]);
                if($data->successful())
                {
                    return $data->object();
                }
            }

        /**
         * @param $request
         * @return object|void
         */
        public static function B2C($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                    ->withToken(self::generatetoken()->access_token)
                    ->post(MpesaParameters::link().MpesaParameters::b2c_link, [ 'InitiatorName' => $request[ 'initiator' ] , 'SecurityCredential' => self::cert($request[ 'credential' ]) , 'CommandID' => $request[ 'CommandID' ] , 'Amount' => $request[ 'amount' ] , 'PartyA' => $request[ 'shortcode' ] , 'PartyB' => $request[ 'msisdn' ] , 'Remarks' => $request[ 'remarks' ] , 'QueueTimeOutURL' => MpesaParameters::b2ccallback() , 'ResultURL' => MpesaParameters::b2ccallback() , 'Occasion' => $request[ 'ocassion' ] ]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }

        /**
         * @param $request
         * @return object|void
         */
        public static function transactionstatus($request)
            {
                $data       =   Http::withHeaders(['Content-Type'=>'application/json',"accept" => "application/json"])
                                    ->withOptions(['verify' => app_path('Resources/cacert.pem'), 'http_errors' => false])
                                    ->withToken(self::generatetoken()->access_token)
                                    ->post(MpesaParameters::link().MpesaParameters::transtat_link, [ 'Initiator' => $request[ 'initiator' ] , 'SecurityCredential' => self::cert($request[ 'credential' ]) , 'CommandID' => 'TransactionStatusQuery' , 'TransactionID' => $request[ 'transID' ] , 'PartyA' => $request[ 'msisdn' ] , 'IdentifierType' => self::getIdentifier($request[ 'identifier' ]) , 'ResultURL' => MpesaParameters::transtatURL() , 'QueueTimeOutURL' => MpesaParameters::transtatURL() , 'Remarks' => $request[ 'remarks' ] , 'Occasion' => $request[ 'ocassion' ] , 'OriginalConversationID' => $request[ 'conversionID' ] ]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }

    }

