<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorSpecialtyRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctors_id' => 'required|exists:doctors,id',  
            'specialty_id' => 'required|exists:specialties,id',  
            'experience' => 'required|integer|min:0',  
        ];
    }

    public function messages()
    {
        return [
            'doctors_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctors_id.exists' => 'Лікар не знайдений в системі.',
            'specialty_id.required' => 'Поле "Спеціальність" є обов\'язковим.',
            'specialty_id.exists' => 'Спеціальність не знайдена в системі.',
            'experience.required' => 'Поле "Досвід" є обов\'язковим.',
            'experience.integer' => 'Досвід має бути цілим числом.',
            'experience.min' => 'Досвід має бути більшим або рівним 0.',
        ];
    }

    public function attributes()
    {
        return [
            'doctors_id' => 'Лікар',
            'specialty_id' => 'Спеціальність',
            'experience' => 'Досвід',
        ];
    }
}
