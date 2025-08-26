<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // CV specific fields
            'job_title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],

            // Profile specific fields
            'first_name_en' => ['required', 'string', 'max:255'],
            'last_name_en' => ['required', 'string', 'max:255'],
            'first_name_ar' => ['required', 'string', 'max:255'],
            'last_name_ar' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'nationality_country_id' => ['nullable', 'exists:countries,id'],
            'residence_country_id' => ['nullable', 'exists:countries,id'],
            'phone_country_id' => ['required', 'exists:countries,id'],
            'phone_number' => ['required', 'string', 'max:20'],
        ];
    }
}