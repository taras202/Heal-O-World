<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyOfficeDoctorRequest extends FormRequest
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
            'bio' => 'nullable|string',                    
            'gender' => 'nullable|string|in:male,female',  
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',  
            'contact' => 'nullable|string|max:255',     
            'time_zone' => 'nullable|string|max:255',       
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Ім\'я є обов\'язковим.',
            'last_name.required' => 'Прізвище є обов\'язковим.',
            'gender.in' => 'Стать повинна бути either male or female.',
            'photo.image' => 'Фото повинно бути зображенням.',
            'photo.mimes' => 'Фото повинно бути одного з форматів: jpeg, png, jpg, gif, svg.',
            'photo.max' => 'Максимальний розмір фото 1MB.',
            'hospital_id.exists' => 'Лікарня з таким ID не існує.',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Ім\'я',
            'last_name' => 'Прізвище',
            'bio' => 'Біографія',
            'gender' => 'Стать',
            'photo' => 'Фото',
            'hospital_id' => 'ID лікарні',
            'country_of_residence' => 'Країна проживання',
            'city_of_residence' => 'Місто проживання',
            'contact' => 'Контакт',
            'time_zone' => 'Часова зона',
        ];
    }
}
