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
            'height' => 'nullable|numeric', 
            'weight' => 'nullable|numeric',
            'notes' => 'nullable|string|max:255',

            'allergic_reactions.*.patient_card_id' => 'required|exists:patient_card,id',
            'allergic_reactions.*.list_allergic_reactions_id' => 'required|exists:list_allergic_reactions,id',

            'chronic_diseases.*.patient_card_id' => 'required|exists:patient_card,id',
            'chronic_diseases.*.list_chronic_diseases_id' => 'required|exists:list_chronic_diseases,id',

            'diseases.*.patient_card_id' => 'required|exists:patient_card,id',
            'diseases.*.list_of_diseases_id' => 'required|exists:list_of_diseases,id',

            'diagnoses.*.patient_card_id' => 'required|exists:patient_card,id',
        ];
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

            'diagnoses.*.patient_card_id.required' => 'Пацієнтська картка є обов\'язковою для діагнозів.',
        ];
    }
}
