<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyOfficePatientRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'contact' => 'nullable|string|max:255',
            'has_insurance' => 'boolean',
            'country_of_residence' => 'nullable|string|max:255',
            'city_of_residence' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ];
    }


    public function messages()
    {
        return [
            'first_name.required' => 'Ім\'я є обов\'язковим.',
            'last_name.required' => 'Прізвище є обов\'язковим.',
            'email.required' => 'Email є обов\'язковим.',
            'email.email' => 'Email має бути у правильному форматі.',
            'email.unique' => 'Цей email вже використовується.',
            'password.required' => 'Пароль є обов\'язковим.',
            'password.min' => 'Пароль має містити щонайменше 6 символів.',
            'password.confirmed' => 'Паролі не співпадають.',
            'date_of_birth.required' => 'Дата народження є обов\'язковою.',
            'gender.in' => 'Стать повинна бути either male or female.',
            'has_insurance.boolean' => 'Страхування має бути значенням true або false.',
            'height.numeric' => 'Зріст має бути числовим значенням.',
            'weight.numeric' => 'Вага має бути числовим значенням.',
            'contact.max' => 'Контактне поле не повинно перевищувати 255 символів.',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Ім\'я',
            'last_name' => 'Прізвище',
            'password' => 'Пароль',
            'password_confirmation' => 'Підтвердження пароля',
            'date_of_birth' => 'Дата народження',
            'gender' => 'Стать',
            'has_insurance' => 'Страхування',
            'country_of_residence' => 'Країна проживання',
            'city_of_residence' => 'Місто проживання',
            'time_zone' => 'Часова зона',
            'height' => 'Зріст',
            'weight' => 'Вага',
            'notes' => 'Примітки',
            'contact' => 'Контакт',
        ];
    }
}
