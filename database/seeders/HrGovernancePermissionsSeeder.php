<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HrGovernancePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Adds HR-specific permissions including the special view_all_nodes permission.
     */
    public function run(): void
    {
        $permissions = [
            // Special permission to view all governance nodes data
            [
                'name'        => 'hr.view_all_nodes',
                'description' => 'View HR data from all governance nodes (bypasses governance filtering)',
            ],

            // Position permissions
            [
                'name'        => 'hrm.positions.view',
                'description' => 'View HR positions',
            ],
            [
                'name'        => 'hrm.positions.create',
                'description' => 'Create HR positions',
            ],
            [
                'name'        => 'hrm.positions.edit',
                'description' => 'Edit HR positions',
            ],
            [
                'name'        => 'hrm.positions.delete',
                'description' => 'Delete HR positions',
            ],

            // Vacancy permissions
            [
                'name'        => 'hrm.vacancies.view',
                'description' => 'View HR vacancies',
            ],
            [
                'name'        => 'hrm.vacancies.create',
                'description' => 'Create HR vacancies',
            ],
            [
                'name'        => 'hrm.vacancies.submit',
                'description' => 'Submit HR vacancies for approval',
            ],
            [
                'name'        => 'hr.vacancies.approve',
                'description' => 'Approve HR vacancies',
            ],
            [
                'name'        => 'hr.vacancies.publish',
                'description' => 'Publish HR vacancies',
            ],

            // Applicant permissions
            [
                'name'        => 'hr.applicants.view',
                'description' => 'View HR applicants',
            ],
            [
                'name'        => 'hr.applicants.manage',
                'description' => 'Manage HR applicants (shortlist, reject)',
            ],
            [
                'name'        => 'hr.applicants.hire',
                'description' => 'Hire HR applicants',
            ],

            // AI Scoring permission
            [
                'name'        => 'hr.ai.score',
                'description' => 'Use AI scoring for applicants',
            ],

            // Employee permissions
            [
                'name'        => 'hr.employees.view',
                'description' => 'View HR employees',
            ],
            [
                'name'        => 'hr.employees.manage',
                'description' => 'Manage HR employees',
            ],

            // Analytics permission
            [
                'name'        => 'hr.analytics.view',
                'description' => 'View HR analytics dashboard',
            ],
        ];

        foreach ($permissions as $permData) {
            Permission::firstOrCreate(
                ['name' => $permData['name']],
                ['guard_name' => 'web']
            );
        }

        // Assign hr.view_all_nodes to super-admin and hr-admin roles if they exist
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo('hr.view_all_nodes');
        }

        $hrAdminRole = Role::where('name', 'hr-admin')->first();
        if ($hrAdminRole) {
            $hrAdminRole->givePermissionTo('hr.view_all_nodes');
        }

        // Create HR Admin role if it doesn't exist
        $hrAdmin = Role::firstOrCreate(['name' => 'hr-admin', 'guard_name' => 'web']);
        $hrAdmin->syncPermissions([
            'hr.view_all_nodes',
            'hrm.positions.view',
            'hrm.positions.create',
            'hrm.positions.edit',
            'hrm.positions.delete',
            'hrm.vacancies.view',
            'hrm.vacancies.create',
            'hrm.vacancies.submit',
            'hr.vacancies.approve',
            'hr.vacancies.publish',
            'hr.applicants.view',
            'hr.applicants.manage',
            'hr.applicants.hire',
            'hr.ai.score',
            'hr.employees.view',
            'hr.employees.manage',
            'hr.analytics.view',
        ]);

        // Create HR Manager role (governance-scoped, no view_all_nodes)
        $hrManager = Role::firstOrCreate(['name' => 'hr-manager', 'guard_name' => 'web']);
        $hrManager->syncPermissions([
            'hrm.positions.view',
            'hrm.positions.create',
            'hrm.vacancies.view',
            'hrm.vacancies.create',
            'hrm.vacancies.submit',
            'hr.applicants.view',
            'hr.applicants.manage',
            'hr.ai.score',
            'hr.employees.view',
            'hr.analytics.view',
        ]);

        $this->command->info('HR governance permissions seeded successfully.');
        $this->command->info('- hr.view_all_nodes: Allows viewing HR data from ALL governance nodes');
        $this->command->info('- hr-admin role: Has view_all_nodes permission');
        $this->command->info('- hr-manager role: Governance-scoped (sees only their node\'s data)');
    }
}
