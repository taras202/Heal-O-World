<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'text' => 'required|string',  
            'consultation_id' => 'required|exists:consultations,id',  
            'status' => 'required|string|in:pending,resolved,closed',  
            'sender_id' => 'required|exists:users,id',  
            'type' => 'required|string|in:general,technical', 
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'Поле "Текст" є обов\'язковим.',
            'consultation_id.required' => 'Поле "Консультація" є обов\'язковим.',
            'consultation_id.exists' => 'Вказана консультація не знайдена.',
            'status.required' => 'Поле "Статус" є обов\'язковим.',
            'status.in' => 'Статус може бути лише одним з таких: pending, resolved, closed.',
            'sender_id.required' => 'Поле "Відправник" є обов\'язковим.',
            'sender_id.exists' => 'Вказаний відправник не знайдений в системі.',
            'type.required' => 'Поле "Тип" є обов\'язковим.',
            'type.in' => 'Тип може бути лише одним з таких: general, technical.',
        ];
    }

    public function attributes()
    {
        return [
            'text' => 'Текст скарги',
            'consultation_id' => 'Консультація',
            'status' => 'Статус',
            'sender_id' => 'Відправник',
            'type' => 'Тип скарги',
        ];
    }
}
