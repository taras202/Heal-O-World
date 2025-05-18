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
        $rules = [
            'patient_id' => 'required|exists:my_office_patients,id',
            'height' => 'nullable|numeric', 
            'weight' => 'nullable|numeric',
            'notes' => 'nullable|string|max:255',
        ];
    
        $isUpdate = $this->routeIs('patient-cards.update');
    
        $rules['allergic_reactions'] = 'array';
        $rules['chronic_diseases'] = 'array';
        $rules['diseases'] = 'array';
        $rules['diagnoses'] = 'array';
    
        foreach (['allergic_reactions', 'chronic_diseases', 'diseases', 'diagnoses'] as $section) {
            $field = match($section) {
                'allergic_reactions' => 'list_allergic_reactions_id',
                'chronic_diseases' => 'list_chronic_diseases_id',
                'diseases' => 'list_of_diseases_id',
                'diagnoses' => 'list_diagnoses_id', 
            };
    
            $rules["{$section}.*.{$field}"] = "required|exists:{$this->getTableForField($field)},id";
        }
    
        return $rules;
    }
    
    private function getTableForField($field)
    {
        return match($field) {
            'list_allergic_reactions_id' => 'list_allergic_reactions',
            'list_chronic_diseases_id' => 'list_chronic_diseases',
            'list_of_diseases_id' => 'list_of_diseases',
            'list_diagnoses_id' => 'list_diagnoses',
        };
    }
    
    public function messages()
    {
        return [
            'patient_id.required' => 'Поле "Пацієнт" є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'notes.string' => 'Поле "Нотатки" повинно бути текстом.',
            'notes.max' => 'Нотатки повинні містити не більше 255 символів.',

            'allergic_reactions.*.patient_card_id.required' => 'Пацієнтська картка є обов\'язковою для алергічної реакції.',
            'allergic_reactions.*.list_allergic_reactions_id.required' => 'Реакція на алергію є обов\'язковою.',
            'allergic_reactions.*.list_allergic_reactions_id.exists' => 'Реакція на алергію не знайдена.',

            'chronic_diseases.*.patient_card_id.required' => 'Пацієнтська картка є обов\'язковою для хронічних захворювань.',
            'chronic_diseases.*.list_chronic_diseases_id.required' => 'Хронічне захворювання є обов\'язковим.',
            'chronic_diseases.*.list_chronic_diseases_id.exists' => 'Хронічне захворювання не знайдено.',

            'diseases.*.patient_card_id.required' => 'Пацієнтська картка є обов\'язковою для захворювань.',
            'diseases.*.list_of_diseases_id.required' => 'Захворювання є обов\'язковим.',
            'diseases.*.list_of_diseases_id.exists' => 'Захворювання не знайдено.',

            'diagnoses.*.list_diagnoses_id.required' => 'Діагноз є обов\'язковим.',
            'diagnoses.*.list_diagnoses_id.exists' => 'Діагноз не знайдено.',
        ];
    }
}
