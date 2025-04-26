<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1950|max:' . date('Y'),
            'end_year' => 'nullable|integer|min:1950|max:' . date('Y'),
    
            'diploma_photo_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'diploma_photo_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'diploma_photo_3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }    
}
