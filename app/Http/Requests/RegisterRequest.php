<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::guest();
    }



    public function rules()
    {
        return [
            'first_name'    =>  'required|string|max:255',
            'last_name'     =>  'required|string|max:255',
            'email'         =>  'required|email|max:255',
            'password'      =>  'required',
        ];
    }
}
