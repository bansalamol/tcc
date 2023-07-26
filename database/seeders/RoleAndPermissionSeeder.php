<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'show_all_patients', // Permission to show all patients
        ]);
        Permission::firstOrCreate([
            'name' => 'show_all_appointments', // Permission to show all appointments
        ]);
        Permission::firstOrCreate([
            'name' => 'show_own_patient_contact', // Permission to show own patient contact details
        ]);
        Permission::firstOrCreate([
            'name' => 'show_assigned_patient_contact', // Permission to show assigned patient contact details
        ]);

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
        $adminRole->syncPermissions(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $managerRole->syncPermissions([
            'manage patients',
            'manage appointments',
            'show_all_patients',
            'show_all_appointments',
            'show_own_patient_contact',
            'show_assigned_patient_contact',
        ]);

        $presalesRole = Role::firstOrCreate(['name' => 'Presales']);
        $presalesRole->syncPermissions([
            'manage patients',
            'manage appointments',
            'show_own_patient_contact',
            'show_assigned_patient_contact',
        ]);
    }

}
