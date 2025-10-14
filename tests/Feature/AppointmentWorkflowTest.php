<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_appointment(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage appointments');
        $this->actingAs($user);

        $appointment = Appointment::factory()->make();
        $response = $this->post(route('appointments.store'), $appointment->toArray());
        $response->assertRedirect();
        $this->assertDatabaseCount('appointments', 1);
    }

    public function test_unauthorized_user_cannot_create_appointment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $appointment = Appointment::factory()->make();
        $response = $this->post(route('appointments.store'), $appointment->toArray());
        $response->assertStatus(403);
    }
}
