<?php
namespace App\Constants;

class DataParameters
    {

        public const TokenUrl       =   "oauth/v1/generate?grant_type=client_credentials";
        public const DataUrl        =   "";
        public const UserName       =   env('DATA-USERNAME');
        public const Password       =   env('DATA-PASSWORD');
        public const consumerkey    =   env('DATA-CONSUMER-KEY');
        public const consumersecret =   env('DATA-CONSUMER-SECRET');
        public const RedemptionUrl  =   "v2/consumer-resources/auth/billing/redemptionrequest";
        public const BalanceUrl     =   "v2/consumer-resources/auth/billing/query/balance";
        public static function saf_link()
            {
                return (env('APP_ENV') === 'local')?'https://apistg.safaricom.co.ke/':'https://api.safaricom.co.ke/';
            }
    }
