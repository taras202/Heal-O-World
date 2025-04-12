<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientListOfDiseaseRequest extends FormRequest
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
            'patient_id' => 'required|exists:my_office_patients,id', 
            'list_of_diseases_id' => 'required|exists:list_of_diseases,id', 
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
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'list_of_diseases_id.required' => 'Хвороба є обов\'язковою.',
            'list_of_diseases_id.exists' => 'Хвороба не знайдена.',
        ];
    }
}
