<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorSpecialtyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctors_id' => 'required|exists:doctors,id',  
            'specialty_id' => 'required|exists:specialties,id',  
            'experience' => 'required|integer|min:0',  
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
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

    /**
     * Get custom attribute names for validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'doctors_id' => 'Лікар',
            'specialty_id' => 'Спеціальність',
            'experience' => 'Досвід',
        ];
    }
}
