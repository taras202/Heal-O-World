<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'patient_id' => 'required|exists:my_office_patients,id', 
            'sender_id' => 'required|exists:admins,id', 
            'messages' => 'required|string', 
            'status' => 'nullable|string|in:sent,received,read', 
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Вказаний лікар не знайдений в системі.',
            'patient_id.required' => 'Поле "Пацієнт" є обов\'язковим.',
            'patient_id.exists' => 'Вказаний пацієнт не знайдений в системі.',
            'sender_id.required' => 'Поле "Відправник" є обов\'язковим.',
            'sender_id.exists' => 'Вказаний відправник не знайдений в системі.',
            'messages.required' => 'Повідомлення не може бути порожнім.',
            'messages.string' => 'Повідомлення повинно бути рядком.',
            'status.in' => 'Статус може бути тільки одним з наступних: sent, received, read.',
        ];
    }

    public function attributes()
    {
        return [
            'doctor_id' => 'Лікар',
            'patient_id' => 'Пацієнт',
            'sender_id' => 'Відправник',
            'messages' => 'Повідомлення',
            'status' => 'Статус',
        ];
    }
}
