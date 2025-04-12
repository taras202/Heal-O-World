<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => 'required|email|unique:admins,email', 
            'password' => 'required|min:8', 
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
            'email.required' => 'Email є обов\'язковим полем.',
            'email.email' => 'Введіть коректний формат email.',
            'email.unique' => 'Цей email вже зареєстрований.',
            'password.required' => 'Пароль є обов\'язковим полем.',
            'password.min' => 'Пароль має містити не менше 8 символів.',
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
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
