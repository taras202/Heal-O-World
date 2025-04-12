<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorLanguageRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',   
            'language_id' => 'required|exists:languages,id', 
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
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений в системі.',
            'language_id.required' => 'Поле "Мова" є обов\'язковим.',
            'language_id.exists' => 'Мова не знайдена в системі.',
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
            'doctor_id' => 'Лікар',
            'language_id' => 'Мова',
        ];
    }
}
