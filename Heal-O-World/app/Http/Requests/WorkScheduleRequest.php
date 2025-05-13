<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'appointment_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'appointment_date.required' => 'Будь ласка, вкажіть дату консультації.',
            'appointment_date.date' => 'Будь ласка, вкажіть правильну дату.',
            'appointment_date.after_or_equal' => 'Дата консультації повинна бути сьогоднішньою або пізнішою.',
            'consultation_time.required' => 'Будь ласка, вкажіть час консультації.',
            'consultation_time.date_format' => 'Час консультації повинен бути в форматі ГГ:ХХ.',
        ];
    }
}
