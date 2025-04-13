<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiplomaRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',  
            'title' => 'required|string|max:255',          
            'description' => 'nullable|string',            
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений в системі.',
            'title.required' => 'Поле "Заголовок" є обов\'язковим.',
            'title.max' => 'Заголовок не може перевищувати 255 символів.',
            'foto.required' => 'Поле "Фото" є обов\'язковим.',
            'foto.image' => 'Фото має бути зображенням.',
            'foto.mimes' => 'Фото має бути формату jpeg, png, jpg, gif, svg.',
            'foto.max' => 'Розмір фото не може перевищувати 2 MB.',
        ];
    }

    public function attributes()
    {
        return [
            'doctor_id' => 'Лікар',
            'title' => 'Заголовок диплома',
            'description' => 'Опис диплома',
            'foto' => 'Фото диплома',
        ];
    }
}
