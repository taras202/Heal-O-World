<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientListChronicDiseaseRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:my_office_patients,id', 
            'list_chronic_diseases_id' => 'required|exists:list_chronic_diseases,id', 
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'list_chronic_diseases_id.required' => 'Хронічна хвороба є обов\'язковою.',
            'list_chronic_diseases_id.exists' => 'Вибрана хронічна хвороба не існує.',
        ];
    }
}
