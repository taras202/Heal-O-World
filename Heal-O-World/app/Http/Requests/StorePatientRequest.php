<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'has_insurance' => 'required|boolean',
            'country_of_residence' => 'required|string|max:255',
            'city_of_residence' => 'required|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'height' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
