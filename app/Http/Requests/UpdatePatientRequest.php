<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
        'name' => 'required|string|max:100',
        'phone_number' => 'required|string|max:20',
        'sex' => 'required|in:Male,Female,Other', // 'sex' must be one of these values: Male, Female, or Other.
        'birth_date' => 'nullable|date', // 'birth_date' is optional, but if provided, it must be a valid date.
        'age' => 'nullable|integer|min:0', // 'age' is optional, but if provided, it must be a positive integer (zero or greater).
        'profession' => 'nullable|string|max:100',
        'alternate_phone_number' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'required|string|max:255',
        'do_not_contact' => 'nullable|boolean',
        ];
    }
}
