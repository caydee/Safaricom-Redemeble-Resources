<?php

namespace App\Http\Controllers;

use App\Constants\DataParameters;
use App\Utils\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TamaitukController extends Controller
    {

        public function index(Request $request)
            {
                    //dd($request);
                    $request->setMethod('post');
                    $request->request->add(['msisdn'=>'0713154085','description'=>'SAFPROMO20MBS','pin'=>'TAMAITUK',
                            'password'=>'T@m@#Took']);
                    $data = Data::redemption($request);
                    dd($data);
                }
    }

