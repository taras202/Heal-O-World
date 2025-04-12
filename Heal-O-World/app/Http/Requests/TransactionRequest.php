<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'payment_id' => 'required|exists:payments,id', 
            'doctor_id' => 'required|exists:my_office_doctors,id', 
            'patient_id' => 'required|exists:my_office_patients,id', 
            'amount' => 'required|numeric|min:0', 
            'transaction_type' => 'required|string|in:credit,debit', 
            'status' => 'required|string|in:pending,completed,failed', 
            'description' => 'nullable|string|max:1000', 
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
            'payment_id.required' => 'Поле payment_id є обов\'язковим.',
            'payment_id.exists' => 'Зазначена транзакція не знайдена.',
            'doctor_id.required' => 'Поле doctor_id є обов\'язковим.',
            'doctor_id.exists' => 'Зазначений лікар не знайдений.',
            'patient_id.required' => 'Поле patient_id є обов\'язковим.',
            'patient_id.exists' => 'Зазначений пацієнт не знайдений.',
            'amount.required' => 'Поле amount є обов\'язковим.',
            'amount.numeric' => 'Поле amount повинно бути числом.',
            'amount.min' => 'Поле amount повинно бути більшим або рівним 0.',
            'transaction_type.required' => 'Поле transaction_type є обов\'язковим.',
            'transaction_type.in' => 'Поле transaction_type має бути або "credit", або "debit".',
            'status.required' => 'Поле status є обов\'язковим.',
            'status.in' => 'Поле status має бути одним із значень: pending, completed, failed.',
            'description.string' => 'Опис повинен бути рядком.',
            'description.max' => 'Опис не може перевищувати 1000 символів.',
        ];
    }
}
