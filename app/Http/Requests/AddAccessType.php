<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAccessType extends FormRequest
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
                            'access_type_name'          =>  ['required','unique:access_types,access_name'],
                            'access_type_description'   =>  ['nullable']
                        ];
            }
    }
