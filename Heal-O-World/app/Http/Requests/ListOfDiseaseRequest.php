<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListOfDiseaseRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',  
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "Назва" є обов\'язковим.',
            'title.string' => 'Назва повинна бути рядком.',
            'title.max' => 'Назва не може перевищувати 255 символів.',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Назва',
        ];
    }
}
