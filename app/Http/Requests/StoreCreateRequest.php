<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateRequest extends FormRequest
{
    public function authorize()
    {
        return !\Auth::guest();
    }



    public function rules()
    {
        return [
            'name'              => 'required|string|max:50',
            'subdomain'         => 'required|string|max:30',
            'store_category_id' => 'required',
        ];
    }
}
