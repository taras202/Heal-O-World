<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientListAllergicReactionRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:my_office_patients,id', 
            'list_allergic_reactions_id' => 'required|exists:list_allergic_reactions,id', 
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'list_allergic_reactions_id.required' => 'Алергічна реакція є обов\'язковою.',
            'list_allergic_reactions_id.exists' => 'Алергічна реакція не знайдена.',
        ];
    }
}
