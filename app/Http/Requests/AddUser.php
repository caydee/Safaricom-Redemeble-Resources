<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUser extends FormRequest
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
                return  [
                            'name'          =>  ['required'],
                            'email'         =>  ['required','unique:users,email'],
                            'password'      =>  ['required_with:con_password','same:con_password'],
                            'con_password'  =>  ['required','min:6']
                        ];
            }
    }
