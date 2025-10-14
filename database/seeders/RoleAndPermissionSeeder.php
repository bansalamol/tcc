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
        $permissions = [
            'manage patients',
            'manage appointments',
            'show_all_patients',
            'show_all_appointments',
            'show_own_patient_contact',
            'show_assigned_patient_contact',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
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
