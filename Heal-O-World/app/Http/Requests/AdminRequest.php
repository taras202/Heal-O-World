<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:admins,email', 
            'password' => 'required|min:8', 
        ];
    }

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

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
