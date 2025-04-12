<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalRequest extends FormRequest
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
            'name' => 'required|string|max:255',  
            'address' => 'required|string|max:255',  
            'description' => 'nullable|string',  
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
            'name.required' => 'Поле "Назва" є обов\'язковим.',
            'name.string' => 'Назва лікарні має бути рядком.',
            'name.max' => 'Назва лікарні не може перевищувати 255 символів.',
            'address.required' => 'Поле "Адреса" є обов\'язковим.',
            'address.string' => 'Адреса лікарні має бути рядком.',
            'address.max' => 'Адреса лікарні не може перевищувати 255 символів.',
            'description.string' => 'Опис лікарні має бути рядком.',
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
            'name' => 'Назва',
            'address' => 'Адреса',
            'description' => 'Опис',
        ];
    }
}
