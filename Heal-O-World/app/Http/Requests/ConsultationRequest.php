<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',  
            'doctor_id' => 'required|exists:doctors,id',    
            'google_meet_link' => 'nullable|url',            
            'appointment_date' => 'required|date',           
            'consultation_time' => 'required|string',        
            'diagnosis' => 'nullable|string',                 
            'prescription' => 'nullable|string',              
            'status' => 'nullable|string|in:pending,completed,canceled', 
            'treatment' => 'nullable|string',                
            'notes' => 'nullable|string',                    
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'patient_id.required' => 'Поле "Пацієнт" є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений в системі.',
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений в системі.',
            'google_meet_link.url' => 'Введений URL для Google Meet є некоректним.',
            'appointment_date.required' => 'Поле "Дата прийому" є обов\'язковим.',
            'appointment_date.date' => 'Поле "Дата прийому" має бути коректною датою.',
            'consultation_time.required' => 'Поле "Час прийому" є обов\'язковим.',
            'status.in' => 'Статус може бути тільки одним з наступних: pending, completed, canceled.',
        ];
    }

    /**
     * Get custom attribute names for validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'patient_id' => 'Пацієнт',
            'doctor_id' => 'Лікар',
            'google_meet_link' => 'Посилання на Google Meet',
            'appointment_date' => 'Дата прийому',
            'consultation_time' => 'Час прийому',
            'diagnosis' => 'Діагноз',
            'prescription' => 'Рецепт',
            'status' => 'Статус',
            'treatment' => 'Лікування',
            'notes' => 'Нотатки',
        ];
    }
}
