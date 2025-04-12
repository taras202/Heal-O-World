<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CacheRequest extends FormRequest
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
            'key' => 'required|string|max:255|unique:cache,key', 
            'value' => 'required|string', 
            'expiration' => 'required|integer|min:1', 
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
            'key.required' => 'Ключ є обов\'язковим полем.',
            'key.string' => 'Ключ має бути рядком.',
            'key.max' => 'Ключ не може перевищувати 255 символів.',
            'key.unique' => 'Цей ключ вже існує в системі.',
            'value.required' => 'Значення є обов\'язковим полем.',
            'value.string' => 'Значення повинно бути рядком.',
            'expiration.required' => 'Поле часового обмеження є обов\'язковим.',
            'expiration.integer' => 'Часове обмеження повинно бути числом.',
            'expiration.min' => 'Часове обмеження повинно бути більше або рівне 1.',
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
            'key' => 'Ключ',
            'value' => 'Значення',
            'expiration' => 'Часове обмеження',
        ];
    }
}
