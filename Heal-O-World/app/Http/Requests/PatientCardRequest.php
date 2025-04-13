<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientCardRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:my_office_patients,id', 
            'visit_date' => 'required|date', 
            'diagnosis' => 'nullable|string|max:255', 
            'notes' => 'nullable|string', 
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'visit_date.required' => 'Дата візиту є обов\'язковою.',
            'visit_date.date' => 'Дата візиту повинна бути валідною датою.',
            'diagnosis.string' => 'Діагноз повинен бути рядком.',
            'diagnosis.max' => 'Діагноз не може перевищувати 255 символів.',
            'notes.string' => 'Примітки повинні бути рядком.',
        ];
    }
}
