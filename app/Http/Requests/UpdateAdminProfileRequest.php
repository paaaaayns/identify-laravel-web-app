<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'religion' => ['nullable', 'string', 'max:255'],
            'civil_status' => ['required', 'string', 'max:255'],
            'citizenship' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'This field is required',
            'contact_number.regex' => 'Please enter a valid contact number',
            'contact_number.min' => 'Please enter a valid contact number',
            'max' => 'This field cannot be more than :max characters',
        ];
    }
}
