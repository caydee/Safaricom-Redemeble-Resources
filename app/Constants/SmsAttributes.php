<?php


namespace App\Constants;


class SmsAttributes
    {
        public const accesstokenurl     =   'https://dsvc.safaricom.com:9480/api/auth/login';
        public const apiusername        =   env('sms_api_username');
        public const apipassword        =   env('sms_api_password');
        public const refreshtokenurl    =   '';
        public const BulkSendUrl        =   'https://dsvc.safaricom.com:9480/api/public/CMS/bulksms';
        public const bulkSmsCallback    =   '';
        public const sendSmsUrl         =   'https://dsvc.safaricom.com:9480/api/public/SDP/sendSMSRequest';
        public const subscriptionUrl    =   'https://dsvc.safaricom.com:9480/api/public/SDP/activate';
        public const unSubscriptionUrl  =   'https://dsvc.safaricom.com:9480/api/public/SDP/deactivate';
        public const packageId          =   env('sms_package_id');


    }
