<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'patient_code' => 'required|string|max:255',
            'clinic' => 'required|string|max:255',
            'appointment_type' => 'required|string|max:255',
            'appointment_time' => 'required|date',
            'lead_interest_score' => 'nullable|integer',
            'health_problem' => 'required|array|min:1',
            'health_problem.*' => 'required|string|max:255',
            'current_status' => 'required|string|max:255',
            'cancellation_reason' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id', // Assuming the 'assigned_to' field is a foreign key referencing the 'id' field in the 'users' table.
            'reference_id' => 'nullable|exists:appointments,id', // Assuming the 'reference_id' field is a foreign key referencing the 'id' field in the 'appointments' table.
            'missed_appointment_executive_id' => 'nullable|exists:users,id', // Assuming the 'missed_appointment_executive_id' field is a foreign key referencing the 'id' field in the 'users' table.
            'active' => 'nullable|string|max:255',
            'visited' => 'nullable|string|max:255',
            'last_called_datetime' => 'nullable|date', // Assuming the 'last_called_datetime' field is a datetime field.
            'last_messaged_datetime' => 'nullable|date', // Assuming the 'last_messaged_datetime' field is a datetime field.
            'lead_source' => 'nullable|string|max:30'
        ];
    }
}
