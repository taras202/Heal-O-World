<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . $this->route('user'), 
            'password' => 'required|string|min:8|confirmed', 
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Ім\'я" є обов\'язковим.',
            'name.string' => 'Ім\'я повинно бути рядком.',
            'name.max' => 'Ім\'я не повинно перевищувати 255 символів.',
            'email.required' => 'Поле "Email" є обов\'язковим.',
            'email.email' => 'Введіть коректну електронну пошту.',
            'email.unique' => 'Ця електронна пошта вже використовується.',
            'password.required' => 'Поле "Пароль" є обов\'язковим.',
            'password.string' => 'Пароль повинен бути рядком.',
            'password.min' => 'Пароль повинен бути не менше 8 символів.',
            'password.confirmed' => 'Паролі не співпадають.',
        ];
    }
}
