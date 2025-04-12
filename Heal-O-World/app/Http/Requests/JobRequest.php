<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'queue' => 'required|string|max:255',  
            'payload' => 'required|string',  
            'attempts' => 'required|integer|min:0',  
            'reserved_at' => 'nullable|date',  
            'available_at' => 'nullable|date',  
            'created_at' => 'nullable|date',  
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
            'queue.required' => 'Поле "Черга" є обов\'язковим.',
            'queue.string' => 'Назва черги має бути рядком.',
            'queue.max' => 'Назва черги не може перевищувати 255 символів.',
            'payload.required' => 'Поле "Payload" є обов\'язковим.',
            'payload.string' => 'Payload має бути рядком.',
            'attempts.required' => 'Поле "Кількість спроб" є обов\'язковим.',
            'attempts.integer' => 'Кількість спроб має бути цілим числом.',
            'attempts.min' => 'Кількість спроб не може бути менше 0.',
            'reserved_at.date' => 'Час резервування має бути валідною датою.',
            'available_at.date' => 'Час доступності має бути валідною датою.',
            'created_at.date' => 'Час створення має бути валідною датою.',
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
            'queue' => 'Черга',
            'payload' => 'Payload',
            'attempts' => 'Кількість спроб',
            'reserved_at' => 'Час резервування',
            'available_at' => 'Час доступності',
            'created_at' => 'Час створення',
        ];
    }
}
