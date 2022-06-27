<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends Controller
    {
        public function login(Request $request)
            {
                $request->validate ([ 'email' => 'required|string|email' , 'password' => 'required|string' ]);
                $credentials = request ([ 'email' , 'password' ]);
                // print_r($credentials);die;
                if (!Auth::attempt ($credentials))
                    {
                        return response ()->json ([ 'message' => 'Unauthorized' ] , 401);
                    }
                $user           =   $request->user ();
                $tokenResult    =   $user->createToken ('Personal Access Token');

                //dd($tokenResult);

                $token          =   $tokenResult->token;
                if ($request->remember_me)
                    {
                        $token->expires_at = date_create('now')->add(new \DateInterval('T1H'));
                    }
                $token->save ();
                return response ()->json ([ 'access_token' => $tokenResult->accessToken ,
                    //'refresh_token' => $tokenResult->refreshToken,
                    'token_type' => 'Bearer' , 'expires_at' => Carbon::parse ($tokenResult->token->expires_at)->toDateTimeString () ]);
            }

        public function register(Request $request)
            {
                $request->validate ([ 'fName' => 'required|string' , 'lName' => 'required|string' , 'email' => 'required|string|email|unique:users' , 'password' => 'required|string' ]);
                $user = new User;
                $user->first_name = $request->fName;
                $user->last_name = $request->lName;
                $user->email = $request->email;
                $user->password = bcrypt ($request->password);
                $user->save ();
                return response ()->json ([ 'message' => 'Successfully created user!' ] , 201);
            }

        public function logout(Request $request)
            {
                $request->user ()->token ()->revoke ();
                return response ()->json ([ 'message' => 'Successfully logged out']);
            }

        public function user(Request $request)
            {
                return response()->json ($request->user ());

                //new AccessTokenController();
            }
    }
