<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_patient(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage patients');
        $this->actingAs($user);

        $response = $this->post(route('patients.store'), Patient::factory()->make()->toArray());
        $response->assertRedirect();
        $this->assertDatabaseCount('patients', 1);
    }

    public function test_unauthorized_user_cannot_create_patient(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('patients.store'), Patient::factory()->make()->toArray());
        $response->assertStatus(403);
    }
}
