<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkScheduleRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id', 
            'day_of_the_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', 
            'hours_with' => 'required|date_format:H:i', 
            'hours_after' => 'required|date_format:H:i|after:hours_with', 
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
            'doctor_id.required' => 'Поле "Лікар" є обов\'язковим.',
            'doctor_id.exists' => 'Вибраний лікар не існує.',
            'day_of_the_week.required' => 'Поле "День тижня" є обов\'язковим.',
            'day_of_the_week.in' => 'День тижня має бути одним з наступних: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday.',
            'hours_with.required' => 'Поле "Час початку" є обов\'язковим.',
            'hours_with.date_format' => 'Час початку має бути у форматі HH:MM.',
            'hours_after.required' => 'Поле "Час закінчення" є обов\'язковим.',
            'hours_after.date_format' => 'Час закінчення має бути у форматі HH:MM.',
            'hours_after.after' => 'Час закінчення має бути пізніше часу початку.',
        ];
    }
}
