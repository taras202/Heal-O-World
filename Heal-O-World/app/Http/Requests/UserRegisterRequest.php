<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'    => 'nullable|string|max:20',
            'email'    => 'required|email|unique:users,email',
            'status'   => 'nullable|string|max:50',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:doctor,patient', 
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Емейл обовʼязковий.',
            'email.email'       => 'Невірний формат емейлу.',
            'email.unique'      => 'Цей емейл вже використовується.',
            'password.required' => 'Пароль обовʼязковий.',
            'password.min'      => 'Пароль має містити щонайменше 6 символів.',
            'role.required'     => 'Роль обовʼязкова.',
            'role.in'           => 'Невірна роль. Доступні ролі: doctor, patient.', 
        ];
    }
}
