<?php

namespace App\Http\Controllers;

use App\Traits\Mpesa;
use Illuminate\Http\Request;

class PaymentsController extends Controller
    {
        use Mpesa;
        public function register(Request $request)
            {
                return Mpesa::c2b_register($request);
            }
    }
