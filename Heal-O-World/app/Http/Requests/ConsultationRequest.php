<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'patient_id' => 'nullable|exists:my_office_patients,id', 
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'google_meet_link' => 'nullable|url', 
            'appointment_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
            'diagnosis' => 'nullable|string|max:500',
            'prescription' => 'nullable|string|max:500',
            'status' => 'required|in:pending,completed,canceled',
            'treatment' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'A patient ID is required.',
            'doctor_id.required'  => 'A doctor ID is required.',
            'appointment_date.required' => 'Please provide an appointment date.',
            'consultation_time.required' => 'Consultation time is required.',
            'status.required' => 'The status of the consultation is required.',
            'status.in' => 'The status must be one of the following: pending, completed, canceled.',
        ];
    }
}
