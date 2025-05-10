<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyOfficeDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

        return [
            'user_id' => $isUpdate ? 'required|exists:users,id' : 'nullable',

            'email' => $isUpdate ? 'nullable' : 'required|email|unique:users,email',
            'password' => $isUpdate ? 'nullable' : 'required|string|min:6|confirmed',
            'status' => 'nullable|boolean',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'gender' => 'required|in:чоловік,жінка,інше',
            'photo' => 'nullable|image|max:2048',
            'contact' => 'required|string|max:255',
            'time_zone' => 'required|string|max:100',

            'specialties' => 'nullable|array',
            'specialties.*' => 'exists:specialties,id',
            'specialty_data' => 'nullable|array',
            'specialty_data.*.experience' => 'nullable|numeric|min:0',
            'specialty_data.*.price' => 'nullable|numeric|min:0',

            'educations' => 'nullable|array',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.start_year' => 'required|digits:4|integer',
            'educations.*.end_year' => 'nullable|digits:4|integer|gte:educations.*.start_year',
            'educations.*.diploma_photo_1' => 'nullable|image|max:2048',
            'educations.*.diploma_photo_2' => 'nullable|image|max:2048',
            'educations.*.diploma_photo_3' => 'nullable|image|max:2048',

            'place_of_work' => 'nullable|array',
            'place_of_work.workplace' => 'required_with:place_of_work|string|max:255',
            'place_of_work.position' => 'required_with:place_of_work|string|max:255',
            'place_of_work.country_of_residence' => 'required_with:place_of_work|string|max:255',
            'place_of_work.city_of_residence' => 'required_with:place_of_work|string|max:255',
        ];
    }
}
