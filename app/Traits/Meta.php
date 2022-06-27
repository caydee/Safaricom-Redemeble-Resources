<?php


namespace App\Traits;


use App\Models\Rate;
use phpDocumentor\Reflection\Types\Array_;

trait Meta
    {
        public static function site_def() :array
            {
                return  [
                            'name'          =>  'Tamaituk',
                            'title'         =>  'Best sms and data solutions',
                            'description'   =>  'Helping you connect to the consumers, making them enjoy mobile technology from the comfort of their palms',
                            'keywords'      =>  'Data,Sms, vas',
                            'author'        =>  'Tamaituk',
                            'logo'          =>  'assets/img/logo.png'
                        ];
            }
        public static function success($title,$message,$redirecturl="") : array
            {
                return  [
                            'status'    =>  TRUE,
                            'msg'       =>  $message,
                            'header'    =>  $title,
                            'url'       =>  $redirecturl
                        ];
            }

        public static function fail($title,$message,$redirecturl="") : array
            {
                return [
                            'status'    =>  FALSE,
                            'msg'       =>  $message,
                            'header'    =>  $title,
                            'url'       =>  $redirecturl
                        ];
            }
        public static function process_array($data) : array
            {
                foreach($data as $value)
                    {
                        $dt[$value['name']]   =   $value['value'];
                    }
                return $dt;
                //return collect($dt);
            }
        public static function rate($orgid,$prodid,$amount)
            {
                $rate   =   Rate::where('organization_id',$orgid)
                                ->where('product_id',$prodid)
                                ->where('min_value','<=',$amount)
                                ->where('max_value','>=',$amount)
                                ->where('status',1)
                                ->first();
                if(is_null($rate))
                    {
                        $rate   =   Rate::where('organization_id',$orgid)
                                        ->where('product_id',$prodid)
                                        ->where('status',1)
                                        ->orderBy('max_value', 'desc')
                                        ->first();
                    }
                return $rate->unit_cost??0.8;
            }
    }
