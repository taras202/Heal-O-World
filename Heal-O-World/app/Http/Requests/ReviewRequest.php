<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'patient_id' => 'required|exists:my_office_patients,id', 
            'rating' => 'required|integer|between:1,5', 
            'content' => 'nullable|string|max:1000', 
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Лікар є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений.',
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'rating.required' => 'Рейтинг є обов\'язковим.',
            'rating.integer' => 'Рейтинг повинен бути цілим числом.',
            'rating.between' => 'Рейтинг повинен бути між 1 і 5.',
            'content.string' => 'Вміст повинен бути рядком.',
            'content.max' => 'Вміст не повинен перевищувати 1000 символів.',
        ];
    }
}
