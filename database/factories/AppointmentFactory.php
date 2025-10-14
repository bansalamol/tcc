<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'patient_code' => Patient::factory(),
            'clinic' => 'Main',
            'appointment_type' => 'Confirmed',
            'appointment_time' => now()->addDay(),
            'health_problem' => 'Test',
            'current_status' => 'New',
            'comments' => 'test',
            'assigned_to' => User::factory(),
        ];
    }
}
