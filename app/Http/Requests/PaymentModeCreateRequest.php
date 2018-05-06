<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentModeCreateRequest extends FormRequest
{

    public function authorize()
    {
        return !\Auth::guest();
    }



    public function rules()
    {
        return [
            'title'     => 'required|string|max:100',
        ];
    }
}
