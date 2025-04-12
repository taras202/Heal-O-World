<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListChronicDiseaseRequest extends FormRequest
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
            'title' => 'required|string|max:255',  
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
            'title.required' => 'Поле "Назва" є обов\'язковим.',
            'title.string' => 'Назва повинна бути рядком.',
            'title.max' => 'Назва не може перевищувати 255 символів.',
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
            'title' => 'Назва',
        ];
    }
}
