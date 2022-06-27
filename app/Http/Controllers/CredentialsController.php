<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CredentialsController extends Controller
{
    //Str::random(40)
    public function index()
    {
        $user = auth()->user();
        $credential = Credential::where('user_id',$user->id)->first();
        $this->data['credential'] = $credential;
        return view('modules.credentials.generate',$this->data);
    }

    public function generateCredentials(Request $request)
    {
        $user = auth()->user();
        Credential::updateOrCreate(
            ['user_id'=>$user->id],
            ['user_id'=>$user->id,'name'=>'password','secret'=>Str::random(40),
                'provider'=>'users','password_client'=>1,'redirect'=>'','personal_access_client'=>0,'revoked'=>0]
        );

        return self::success('Api Credential','Success',url('backend/security/credentials'));
    }
    public function documentation()
        {
            return view('modules.credentials.documentation',$this->data);
        }
}
