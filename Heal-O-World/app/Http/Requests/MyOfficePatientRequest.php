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
            'date_of_birth' => 'required|date',              
            'gender' => 'nullable|string|in:male,female',     
            'has_insurance' => 'nullable|boolean',            
            'country_of_residence' => 'nullable|string|max:255', 
            'city_of_residence' => 'nullable|string|max:255',   
            'time_zone' => 'nullable|string|max:255',          
            'height' => 'nullable|numeric|min:0',              
            'weight' => 'nullable|numeric|min:0',              
            'notes' => 'nullable|string',                       
            'contact' => 'nullable|string|max:255',            
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Ім\'я є обов\'язковим.',
            'last_name.required' => 'Прізвище є обов\'язковим.',
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
