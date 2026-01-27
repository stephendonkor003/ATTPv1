<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // HR
            ['name' => 'hr.access', 'module' => 'HR'],
            ['name' => 'hr.positions.view', 'module' => 'HR'],
            ['name' => 'hr.positions.create', 'module' => 'HR'],
            ['name' => 'hr.vacancies.view', 'module' => 'HR'],
            ['name' => 'hr.vacancies.create', 'module' => 'HR'],
            ['name' => 'hr.vacancies.workflow', 'module' => 'HR'],
            ['name' => 'hr.applicants.view', 'module' => 'HR'],
            ['name' => 'hr.applicants.manage', 'module' => 'HR'],
            ['name' => 'hr.applicants.hire', 'module' => 'HR'],
            ['name' => 'hr.ai.score', 'module' => 'HR'],
            ['name' => 'hr.analytics.view', 'module' => 'HR'],

            // Finance
            ['name' => 'finance.access', 'module' => 'Finance'],
            ['name' => 'finance.resources.manage', 'module' => 'Finance'],
            ['name' => 'finance.funders.manage', 'module' => 'Finance'],
            ['name' => 'finance.departments.manage', 'module' => 'Finance'],
            ['name' => 'finance.program_funding.manage', 'module' => 'Finance'],
            ['name' => 'finance.commitments.manage', 'module' => 'Finance'],
            ['name' => 'finance.execution.view', 'module' => 'Finance'],

            // Budget
            ['name' => 'budget.access', 'module' => 'Budget'],
            ['name' => 'budget.structure.manage', 'module' => 'Budget'],
            ['name' => 'budget.activities.manage', 'module' => 'Budget'],
            ['name' => 'budget.allocations.manage', 'module' => 'Budget'],
            ['name' => 'budget.reports.view', 'module' => 'Budget'],
            ['name' => 'budget.summary.view', 'module' => 'Budget'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}