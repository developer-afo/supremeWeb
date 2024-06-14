<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'lng' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999999.9999',
            'size' => 'nullable|string|max:255',
            'img_link' => 'required|image|mimes:jpeg,jpg,png|max:10240',
        ];
        
    }
    
}
