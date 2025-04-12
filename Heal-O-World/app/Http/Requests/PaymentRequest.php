<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'patient_id' => 'required|exists:my_office_patients,id', 
            'transaction_amount' => 'required|numeric|min:0', 
            'status' => 'required|in:pending,completed,canceled', 
            'payment_date' => 'required|date', 
            'appointment_id' => 'required|exists:consultations,id', 
            'transaction_id' => 'required|exists:transactions,id', 
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
            'doctor_id.required' => 'Лікар є обов\'язковим.',
            'doctor_id.exists' => 'Лікар не знайдений.',
            'patient_id.required' => 'Пацієнт є обов\'язковим.',
            'patient_id.exists' => 'Пацієнт не знайдений.',
            'transaction_amount.required' => 'Сума платежу є обов\'язковою.',
            'transaction_amount.numeric' => 'Сума повинна бути числом.',
            'transaction_amount.min' => 'Сума повинна бути більшою або рівною 0.',
            'status.required' => 'Статус є обов\'язковим.',
            'status.in' => 'Статус повинен бути одним з наступних: pending, completed, canceled.',
            'payment_date.required' => 'Дата платежу є обов\'язковою.',
            'payment_date.date' => 'Дата платежу повинна бути у правильному форматі.',
            'appointment_id.required' => 'Консультація є обов\'язковою.',
            'appointment_id.exists' => 'Консультація не знайдена.',
            'transaction_id.required' => 'Транзакція є обов\'язковою.',
            'transaction_id.exists' => 'Транзакція не знайдена.',
        ];
    }
}
