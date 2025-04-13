<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorLanguageRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',   
            'language_id' => 'required|exists:languages,id', 
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений в системі.',
            'language_id.required' => 'Поле "Мова" є обов\'язковим.',
            'language_id.exists' => 'Мова не знайдена в системі.',
        ];
    }

    public function attributes()
    {
        return [
            'doctor_id' => 'Лікар',
            'language_id' => 'Мова',
        ];
    }
}
