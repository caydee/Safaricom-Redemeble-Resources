<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditOrganization extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
            {
                return true;
            }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
            {
                return [
                            'admin_email'       =>  ['required','email'],
                            'admin_name'        =>  ['required'],
                            'phone'             =>  ['required'],
                            'password'          =>  ['required_with:confirm_password','same:confirm_password','nullable'],
                            'organization_name' =>  ['required']
                        ];
            }
    }
