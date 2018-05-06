<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemCreateRequest extends FormRequest
{

    public function authorize()
    {
        return !\Auth::guest();
    }



    public function rules()
    {
        return [
            'product_id'        => 'required|string|max:100',
            'quantity'          => 'required|integer|min:1',
        ];
    }
}
