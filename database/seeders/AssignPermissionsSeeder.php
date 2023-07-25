<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionsSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        // Find or create the 'Administrator' role
        $administratorRole = Role::firstOrCreate(['name' => 'Administrator']);

        // Find or create the 'manage appointments' permission
        $manageAppointmentsPermission = Permission::firstOrCreate(['name' => 'manage appointments']);

        // Assign the 'manage appointments' permission to the 'Administrator' role
        $administratorRole->givePermissionTo($manageAppointmentsPermission);
    }
}
