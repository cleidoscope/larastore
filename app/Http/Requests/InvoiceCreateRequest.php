<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
{
    public function authorize()
    {
        return !\Auth::guest();
    }



    public function rules()
    {
        return [
            'plan_id'           => 'required',
            'street'            => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'province'          => 'required|string|max:100',
            'zip'               => 'required|string|max:100',
            'phone'             => 'required|string|max:100',
        ];
    }
}
