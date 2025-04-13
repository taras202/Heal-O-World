<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string|max:1000', 
            'price' => 'required|numeric|min:0', 
            'currency' => 'required|string|size:3', 
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Лікар є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений.',
            'title.required' => 'Назва є обов\'язковою.',
            'title.string' => 'Назва повинна бути рядком.',
            'title.max' => 'Назва не повинна перевищувати 255 символів.',
            'description.string' => 'Опис повинен бути рядком.',
            'description.max' => 'Опис не повинен перевищувати 1000 символів.',
            'price.required' => 'Ціна є обов\'язковою.',
            'price.numeric' => 'Ціна повинна бути числом.',
            'price.min' => 'Ціна повинна бути не менше 0.',
            'currency.required' => 'Валюта є обов\'язковою.',
            'currency.string' => 'Валюта повинна бути рядком.',
            'currency.size' => 'Валюта повинна містити рівно 3 символи.',
        ];
    }
}
