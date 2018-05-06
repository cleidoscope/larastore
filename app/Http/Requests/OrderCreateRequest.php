<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{

    public function authorize()
    {
        return !\Auth::guest();
    }



    public function rules()
    {
        return [
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'street'            => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'province'          => 'required|string|max:100',
            'phone'             => 'required|string|max:100',
            'zip'               => 'required|string|max:100',
            'shipping_method'   => 'required|string|max:100',
            'payment_mode'      => 'required|string|max:100',
        ];
    }
}
