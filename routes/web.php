<?php

 use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CORE / AUTH / GENERAL CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    DashboardController,
    LandingPageController,
    ProfileController,
    ChangePasswordController,
    UserController,
    PrescreeningTemplateController,
    PrescreeningCriterionController,
    PrescreeningAssignmentController,
    PrescreeningEvaluationController,
    PrescreeningUserAssignmentController,
    EvaluationPanelPdfController,
    PrescreeningReportController,
    EvaluationReportController,
    SystemAuditController,

};

/*
|--------------------------------------------------------------------------
| PUBLIC / EXTERNAL ACCESS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    HrPublicController,
    PublicCheckController,
};

/*
|--------------------------------------------------------------------------
| HR & RECRUITMENT MODULE
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    HrController,
    ApplicantController,
    AssignmentController,
    SiteVisitEvaluationController,
};

/*
|--------------------------------------------------------------------------
| EVALUATION & REVIEW MODULES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    EvaluationController,

    ReportController,
};

/*
|--------------------------------------------------------------------------
| FINANCIAL & COMMITTEE MODULES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    FinancialController,
    CommitteeController,
    CommitteeMemberController,
    CategoryController,
    BidController,
};

/*
|--------------------------------------------------------------------------
| THINK DATASETS / RESEARCH
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    ThinkDatasetController,
};

/*
|--------------------------------------------------------------------------
| BUDGET & FINANCE MODULE
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    SectorController,
    ProgramController,
    ProjectController,
    ActivityController,
    SubActivityController,
    // AllocationController,
    AllocationSummaryController,
    BudgetAllocationController,
    BudgetCommitmentController,
    BudgetReportController,
    ProjectBudgetController,
};

/*
|--------------------------------------------------------------------------
| FUNDING & DEPARTMENTS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    DepartmentController,
    FunderController,
    ProgramFundingController,
    ProgramFundingDocumentController,
    MasterDashboard,
    GovernanceStructureController,
    EvaluationAssignmentController,
};

/*
|--------------------------------------------------------------------------
| SYSTEM / RBAC MANAGEMENT
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\System\{
    RoleController,
    PermissionController,
    UserAccessController,
};

/*
|--------------------------------------------------------------------------
| PROCUREMENT MODULE (DYNAMIC, FORM-BASED)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Procurement\{
    ProcurementController,
    ProcurementWorkflowController,
    DynamicFormController,
    FormSubmissionController,
    PrescreeningController,
    EvaluationController as ProcurementEvaluationController,
    ProcurementPermissionController,
    ProcurementAuditController,
    DynamicFormFieldController,
    ProcurementFormAssignmentController,
    PublicProcurementController,
    ProcurementSubmissionController,


};



Route::middleware(['auth', 'verified'])
    ->prefix('system')
    ->name('system.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | USERS MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::middleware('permission:users.manage')->prefix('users')->name('users.')->group(function () {

            Route::get('/', [UserAccessController::class, 'index'])
                ->name('index');

            Route::get('/create', [UserAccessController::class, 'create'])
                ->name('create');

            Route::post('/', [UserAccessController::class, 'store'])
                ->name('store');

            Route::get('/{user}/edit', [UserAccessController::class, 'edit'])
                ->name('edit');

            Route::put('/{user}', [UserAccessController::class, 'update'])
                ->name('update');

            Route::delete('/{user}', [UserAccessController::class, 'destroy'])
                ->name('destroy');

         /* ===============================
         | ✅ ADD THIS ROUTE
         | Inline Role Update
         =============================== */
        Route::put('/{user}/role', [UserAccessController::class, 'updateRole'])
            ->name('role.update');

        Route::post('/{user}/reset-password', [UserAccessController::class, 'resetPassword'])
            ->name('reset-password');


            Route::get('/{user}/permissions', [UserAccessController::class, 'permissions'])
                ->name('permissions');

            Route::post('/{user}/permissions', [UserAccessController::class, 'syncPermissions'])
                ->name('permissions.sync');

        });


        /*
        |--------------------------------------------------------------------------
        | ROLES MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::middleware('permission:roles.manage')->prefix('roles')->name('roles.')->group(function () {

            Route::get('/', [RoleController::class, 'index'])
                ->name('index');

            Route::get('/create', [RoleController::class, 'create'])
                ->name('create');

            Route::post('/', [RoleController::class, 'store'])
                ->name('store');

            Route::get('/{role}/edit', [RoleController::class, 'edit'])
                ->name('edit');

            Route::put('/{role}', [RoleController::class, 'update'])
                ->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::middleware('permission:permissions.manage')->prefix('permissions')->name('permissions.')->group(function () {

            Route::get('/', [PermissionController::class, 'index'])
                ->name('index');

            Route::get('/{role}/assign', [PermissionController::class, 'assign'])
                ->name('assign');

            Route::post('/{role}/assign', [PermissionController::class, 'storeAssign'])
                ->name('assign.store');
        });
    });




/*
|--------------------------------------------------------------------------
| PUBLIC JOB APPLICATION ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('careers')->name('careers.')->group(function () {

    // List all published vacancies
    Route::get('/', [HrPublicController::class, 'index'])
        ->name('index');

    // View a single vacancy
    Route::get('/{vacancy}', [HrPublicController::class, 'show'])
        ->name('show');

    // Submit application
    Route::post('/{vacancy}/apply', [HrPublicController::class, 'apply'])
        ->name('apply');
});




Route::prefix('careers')->name('careers.')->group(function () {

    // Careers listing page
    Route::get('/', [HrPublicController::class, 'index'])
        ->name('index');

    // Store job application (PUBLIC)
    Route::post('/apply', [HrPublicController::class, 'storeApplication'])
        ->name('apply.store');

});


  Route::middleware(['auth'])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {

        /* =====================================================
         | POSITIONS
         ===================================================== */

        // VIEW
        Route::get('positions', [HrController::class, 'positions'])
            ->middleware('permission:hrm.positions.view')
            ->name('positions.index');

        // CREATE
        Route::post('positions', [HrController::class, 'storePosition'])
            ->middleware('permission:hrm.positions.create')
            ->name('positions.store');


        /* =====================================================
         | VACANCIES
         ===================================================== */

        // VIEW
        Route::get('vacancies', [HrController::class, 'vacancies'])
            ->middleware('permission:hrm.vacancies.view')
            ->name('vacancies.index');

        Route::get('vacancies/{vacancy}/applicants', [HrController::class, 'applicants'])
            ->middleware('permission:hrm.vacancies.view')
            ->name('vacancies.applicants');

        // CREATE / MANAGE
        Route::post('vacancies', [HrController::class, 'storeVacancy'])
            ->middleware('permission:hrm.vacancies.create')
            ->name('vacancies.store');

        // WORKFLOW
        Route::post('vacancies/{vacancy}/submit', [HrController::class, 'submitVacancyForApproval'])
            ->middleware('permission:hrm.vacancies.submit')
            ->name('vacancies.submit');

        Route::post('vacancies/{vacancy}/approve', [HrController::class, 'approveVacancy'])
            ->middleware('permission:hr.vacancies.approve')
            ->name('vacancies.approve');

        Route::post('vacancies/{vacancy}/publish', [HrController::class, 'publishVacancy'])
            ->middleware('permission:hr.vacancies.approve')
            ->name('vacancies.publish');

        Route::post('vacancies/{vacancy}/close', [HrController::class, 'closeVacancy'])
            ->middleware('permission:hr.vacancies.approve')
            ->name('vacancies.close');


        /* =====================================================
         | APPLICANTS
         ===================================================== */

        // VIEW
        Route::get('applicants/{applicant}', [HrController::class, 'showApplicant'])
            ->middleware('permission:hr.applicants.view')
            ->name('applicants.show');

        // MANAGEMENT ACTIONS
        Route::post('applicants/{applicant}/shortlist', [HrController::class, 'shortlistApplicant'])
            ->middleware('permission:hr.applicants.hire')
            ->name('applicants.shortlist');

        Route::post('applicants/{applicant}/reject', [HrController::class, 'rejectApplicant'])
            ->middleware('permission:hr.applicants.hire')
            ->name('applicants.reject');

        Route::post(
            'applicants/{applicant}/schedule-interview',
            [HrController::class, 'scheduleInterview']
        )
            ->middleware('permission:hr.applicants.manage')
            ->name('applicants.interview');

        // HIRE
        Route::post('applicants/{applicant}/hire', [HrController::class, 'hireApplicant'])
            ->middleware('permission:hr.applicants.hire')
            ->name('applicants.hire');


        /* =====================================================
         | AI SCORING
         ===================================================== */

        Route::post('applicants/{applicant}/score-ai', [HrController::class, 'scoreApplicantAI'])
            ->middleware('permission:hr.ai.score')
            ->name('applicants.score');

        Route::post('vacancies/{vacancy}/bulk-score', [HrController::class, 'bulkScoreApplicants'])
            ->middleware('permission:hr.ai.score')
            ->name('vacancies.bulkScore');


        /* =====================================================
         | ANALYTICS
         ===================================================== */

        Route::get('analytics', [HrController::class, 'analytics'])
            ->middleware('permission:hr.analytics.view')
            ->name('analytics');
    });




Route::middleware(['auth', 'permission:finance.access'])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {



       /* =====================================================
         | AJAX ENDPOINTS (USED BY CREATE COMMITMENT PAGE)
         ===================================================== */

        // Load projects
        Route::get('commitments/ajax/projects',
            [BudgetCommitmentController::class, 'projects']
        );

        // Load activities by project
        Route::get('commitments/ajax/activities/{project}',
            [BudgetCommitmentController::class, 'activities']
        );

        // Load sub-activities by activity
        Route::get('commitments/ajax/sub-activities/{activity}',
            [BudgetCommitmentController::class, 'subActivities']
        );

        // Load allocation years
        Route::get('commitments/ajax/allocation-years/{level}/{id}',
            [BudgetCommitmentController::class, 'allocationYears']
        );

        // Remaining budget
        Route::get('commitments/ajax/remaining-budget',
            [BudgetCommitmentController::class, 'remainingBudget']
        );

        // Resources by category
        Route::get('resources/ajax/resources/{category}',
            [BudgetCommitmentController::class, 'resourcesByCategory']
        );

        Route::post('commitments/{commitment}/submit',
            [BudgetCommitmentController::class, 'submit']
        )->name('commitments.submit');



        Route::post('commitments/{commitment}/approve',
            [BudgetCommitmentController::class, 'approve']
        )->name('commitments.approve');

        Route::post('commitments/{commitment}/cancel',
            [BudgetCommitmentController::class, 'cancel']
        )->name('commitments.cancel');
        /* =====================================================
         | RESOURCES
         ===================================================== */

        Route::get('resources/categories', [BudgetCommitmentController::class, 'resourceCategories'])
            ->middleware('permission:finance.resources.view')
            ->name('resources.categories.index');

        Route::post('resources/categories', [BudgetCommitmentController::class, 'storeResourceCategory'])
            ->middleware('permission:finance.resources.create')
            ->name('resources.categories.store');

        Route::get('resources/items', [BudgetCommitmentController::class, 'resources'])
            ->middleware('permission:finance.resources.view')
            ->name('resources.items.index');

        Route::post('resources/items', [BudgetCommitmentController::class, 'storeResource'])
            ->middleware('permission:finance.resources.create')
            ->name('resources.items.store');




          Route::get('execution/dashboard', [MasterDashboard::class, 'executionDashboard'])
            ->middleware('permission:finance.executions.view')
            ->name('execution.dashboard');




        Route::get('execution/data',
            [BudgetCommitmentController::class, 'executionData']
        )->name('execution.data');


        /* =====================================================
         | FUNDERS
         ===================================================== */

        Route::get('funders', [FunderController::class, 'index'])
            ->middleware('permission:finance.funders.view')
            ->name('funders.index');

        Route::get('funders/create', [FunderController::class, 'create'])
            ->middleware('permission:finance.funders.create')
            ->name('funders.create');

        Route::post('funders', [FunderController::class, 'store'])
            ->middleware('permission:finance.funders.create')
            ->name('funders.store');

        Route::get('funders/{funder}', [FunderController::class, 'show'])
            ->middleware('permission:finance.funders.view')
            ->name('funders.show');

        Route::get('funders/{funder}/edit', [FunderController::class, 'edit'])
            ->middleware('permission:finance.funders.edit')
            ->name('funders.edit');

        Route::put('funders/{funder}', [FunderController::class, 'update'])
            ->middleware('permission:finance.funders.edit')
            ->name('funders.update');


        /* =====================================================
         | DEPARTMENTS
         ===================================================== */

        /* =====================================================
         | GOVERNANCE STRUCTURE
         ===================================================== */

        Route::get('governance-structure', [GovernanceStructureController::class, 'index'])
            ->middleware('permission:finance.governance_structure.view')
            ->name('governance.index');

        Route::post('governance-structure/nodes', [GovernanceStructureController::class, 'storeNode'])
            ->middleware('permission:finance.governance_structure.create')
            ->name('governance.nodes.store');

        Route::put('governance-structure/nodes/{node}', [GovernanceStructureController::class, 'updateNode'])
            ->middleware('permission:finance.governance_structure.edit')
            ->name('governance.nodes.update');

        Route::delete('governance-structure/nodes/{node}', [GovernanceStructureController::class, 'destroyNode'])
            ->middleware('permission:finance.governance_structure.delete')
            ->name('governance.nodes.destroy');

        Route::post('governance-structure/lines', [GovernanceStructureController::class, 'storeLine'])
            ->middleware('permission:finance.governance_structure.create')
            ->name('governance.lines.store');

        Route::put('governance-structure/lines/{line}', [GovernanceStructureController::class, 'updateLine'])
            ->middleware('permission:finance.governance_structure.edit')
            ->name('governance.lines.update');

        Route::delete('governance-structure/lines/{line}', [GovernanceStructureController::class, 'destroyLine'])
            ->middleware('permission:finance.governance_structure.delete')
            ->name('governance.lines.destroy');

        Route::post('governance-structure/assignments', [GovernanceStructureController::class, 'storeAssignment'])
            ->middleware('permission:finance.governance_structure.create')
            ->name('governance.assignments.store');

        Route::put('governance-structure/assignments/{assignment}', [GovernanceStructureController::class, 'updateAssignment'])
            ->middleware('permission:finance.governance_structure.edit')
            ->name('governance.assignments.update');

        Route::delete('governance-structure/assignments/{assignment}', [GovernanceStructureController::class, 'destroyAssignment'])
            ->middleware('permission:finance.governance_structure.delete')
            ->name('governance.assignments.destroy');

         /* ===================== DEPARTMENTS ===================== */

        Route::get('departments', [DepartmentController::class, 'index'])
            ->middleware('permission:finance.departments.view')
            ->name('departments.index');

        /* CREATE — MUST COME BEFORE {department} */
        Route::get('departments/create', [DepartmentController::class, 'create'])
            ->middleware('permission:finance.departments.create')
            ->name('departments.create');

        Route::post('departments', [DepartmentController::class, 'store'])
            ->middleware('permission:finance.departments.create')
            ->name('departments.store');

        /* SHOW */
        Route::get('departments/{department}', [DepartmentController::class, 'show'])
            ->middleware('permission:finance.departments.view')
            ->name('departments.show');

        /* EDIT */
        Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])
            ->middleware('permission:finance.departments.edit')
            ->name('departments.edit');

        Route::put('departments/{department}', [DepartmentController::class, 'update'])
            ->middleware('permission:finance.departments.edit')
            ->name('departments.update');

        /* DELETE */
        Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])
            ->middleware('permission:finance.departments.delete')
            ->name('departments.destroy');


        /* =====================================================
         | PROGRAM FUNDING
         ===================================================== */

         /* =====================================================
    | PROGRAM FUNDING
    ===================================================== */

    /* LIST */
    Route::get('program-funding', [ProgramFundingController::class, 'index'])
        ->middleware('permission:finance.program_funding.view')
        ->name('program-funding.index');

    /* CREATE */
    Route::get('program-funding/create', [ProgramFundingController::class, 'create'])
        ->middleware('permission:finance.program_funding.create')
        ->name('program-funding.create');

    Route::post('program-funding', [ProgramFundingController::class, 'store'])
        ->middleware('permission:finance.program_funding.create')
        ->name('program-funding.store');

    /* SHOW */
    Route::get('program-funding/{programFunding}', [ProgramFundingController::class, 'show'])
        ->middleware('permission:finance.program_funding.view')
        ->name('program-funding.show');

    /* EDIT */
    Route::get('program-funding/{programFunding}/edit', [ProgramFundingController::class, 'edit'])
        ->middleware('permission:finance.program_funding.edit')
        ->name('program-funding.edit');

    Route::put('program-funding/{programFunding}', [ProgramFundingController::class, 'update'])
        ->middleware('permission:finance.program_funding.edit')
        ->name('program-funding.update');

    /* DELETE */
    Route::delete('program-funding/{programFunding}', [ProgramFundingController::class, 'destroy'])
        ->middleware('permission:finance.program_funding.delete')
        ->name('program-funding.destroy');


    /* =====================================================
    | WORKFLOW ACTIONS
    ===================================================== */

    /* SUBMIT FOR APPROVAL */
    Route::post('program-funding/{funding}/submit', [ProgramFundingController::class, 'submit'])
        ->middleware('permission:finance.program_funding.submit')
        ->name('program-funding.submit');

    /* APPROVE */
    Route::post('program-funding/{funding}/approve', [ProgramFundingController::class, 'approve'])
        ->middleware('permission:finance.program_funding.approve')
        ->name('program-funding.approve');

    /* REJECT */
    Route::post('program-funding/{funding}/reject', [ProgramFundingController::class, 'reject'])
        ->middleware('permission:finance.program_funding.approve')
        ->name('program-funding.reject');



        /* =====================================================
         | COMMITMENTS
         ===================================================== */

        Route::get('commitments', [BudgetCommitmentController::class, 'index'])
            ->middleware('permission:finance.commitments.view')
            ->name('commitments.index');

        Route::get('commitments/create', [BudgetCommitmentController::class, 'create'])
            ->middleware('permission:finance.commitments.create')
            ->name('commitments.create');

        Route::post('commitments', [BudgetCommitmentController::class, 'store'])
            ->middleware('permission:finance.commitments.create')
            ->name('commitments.store');

        Route::get('commitments/{commitment}', [BudgetCommitmentController::class, 'show'])
            ->middleware('permission:finance.commitments.view')
            ->name('commitments.show');

        Route::get('commitments/{commitment}/edit', [BudgetCommitmentController::class, 'edit'])
            ->middleware('permission:finance.commitments.edit')
            ->name('commitments.edit');

        Route::put('commitments/{commitment}', [BudgetCommitmentController::class, 'update'])
            ->middleware('permission:finance.commitments.edit')
            ->name('commitments.update');

        Route::delete('commitments/{commitment}', [BudgetCommitmentController::class, 'destroy'])
            ->middleware('permission:finance.commitments.delete')
            ->name('commitments.destroy');





});



Route::middleware(['auth'])
    ->prefix('budget')
    ->name('budget.')
    ->group(function () {

        /* =====================================================
         | STRUCTURE: DEPARTMENTS
         ===================================================== */



        /* =====================================================
         | STRUCTURE: SECTORS
         ===================================================== */

        Route::get('sectors', [SectorController::class, 'index'])
            ->middleware('permission:sector.view')
            ->name('sectors.index');

        Route::get('sectors/create', [SectorController::class, 'create'])
            ->middleware('permission:sector.create')
            ->name('sectors.create');

        Route::post('sectors', [SectorController::class, 'store'])
            ->middleware('permission:sector.create')
            ->name('sectors.store');

        Route::get('sectors/{sector}/edit', [SectorController::class, 'edit'])
            ->middleware('permission:sector.edit')
            ->name('sectors.edit');

        Route::put('sectors/{sector}', [SectorController::class, 'update'])
            ->middleware('permission:sector.edit')
            ->name('sectors.update');

        Route::delete('sectors/{sector}', [SectorController::class, 'destroy'])
            ->middleware('permission:sector.delete')
            ->name('sectors.destroy');


        /* =====================================================
         | STRUCTURE: PROGRAMS
         | RBAC handled inside ProgramController
         ===================================================== */

        Route::get('programs', [ProgramController::class, 'index'])
            ->name('programs.index');

        Route::get('programs/create', [ProgramController::class, 'create'])
            ->name('programs.create');

        Route::post('programs', [ProgramController::class, 'store'])
            ->name('programs.store');

        Route::get('programs/{program}', [ProgramController::class, 'show'])
            ->name('programs.show');

        Route::get('programs/{program}/edit', [ProgramController::class, 'edit'])
            ->name('programs.edit');

        Route::put('programs/{program}', [ProgramController::class, 'update'])
            ->name('programs.update');

        Route::delete('programs/{program}', [ProgramController::class, 'destroy'])
            ->name('programs.destroy');


        /* =====================================================
         | STRUCTURE: PROJECTS
         ===================================================== */

        Route::get('projects', [ProjectController::class, 'index'])
            ->middleware('permission:project.view')
            ->name('projects.index');

        Route::get('projects/create', [ProjectController::class, 'create'])
            ->middleware('permission:project.create')
            ->name('projects.create');

        Route::post('projects', [ProjectController::class, 'store'])
            ->middleware('permission:project.create')
            ->name('projects.store');

        Route::get('projects/{project}', [ProjectController::class, 'show'])
            ->middleware('permission:project.view')
            ->name('projects.show');

        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])
            ->middleware('permission:project.edit')
            ->name('projects.edit');

        Route::put('projects/{project}', [ProjectController::class, 'update'])
            ->middleware('permission:project.edit')
            ->name('projects.update');

        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])
            ->middleware('permission:project.delete')
            ->name('projects.destroy');


        /* =====================================================
         | STRUCTURE: ACTIVITIES
         ===================================================== */

        Route::get('activities', [ActivityController::class, 'index'])
            ->middleware('permission:activities.view')
            ->name('activities.index');

        Route::get('activities/{activity}', [ActivityController::class, 'show'])
            ->middleware('permission:activities.view')
            ->name('activities.show');

        Route::get('activities/create/{project}', [ActivityController::class, 'create'])
            // ->middleware('permission:activities.create')
            ->name('activities.create');

        Route::post('activities', [ActivityController::class, 'store'])
            ->middleware('permission:activities.create')
            ->name('activities.store');

        Route::get('activities/{activity}/edit', [ActivityController::class, 'editAllocations'])
            ->middleware('permission:activities.edit')
            ->name('activities.edit');

        Route::put('activities/{activity}', [ActivityController::class, 'update'])
            ->middleware('permission:activities.edit')
            ->name('activities.update');

        Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])
            ->middleware('permission:activities.delete')
            ->name('activities.destroy');


        /* =====================================================
         | STRUCTURE: SUB-ACTIVITIES
         ===================================================== */

        Route::get('subactivities', [SubActivityController::class, 'index'])
            ->middleware('permission:subactivities.view')
            ->name('subactivities.index');

        Route::get('subactivities/{subactivity}', [SubActivityController::class, 'show'])
            ->middleware('permission:subactivities.view')
            ->name('subactivities.show');

        Route::get('activities/{activity}/subactivities/create', [SubActivityController::class, 'create'])
            ->middleware('permission:subactivities.create')
            ->name('subactivities.create');

        Route::post('subactivities', [SubActivityController::class, 'store'])
            ->middleware('permission:subactivities.create')
            ->name('subactivities.store');

        Route::get('subactivities/{subactivity}/edit', [SubActivityController::class, 'edit'])
            ->middleware('permission:subactivities.edit')
            ->name('subactivities.edit');

        Route::put('subactivities/{subactivity}', [SubActivityController::class, 'update'])
            ->middleware('permission:subactivities.edit')
            ->name('subactivities.update');

        Route::get('subactivities/{subactivity}/edit-allocations', [SubActivityController::class, 'editAllocations'])
            ->middleware('permission:subactivity.edit')
            ->name('subactivities.allocations.edit');

        Route::post('subactivities/{subactivity}/update-allocations', [SubActivityController::class, 'updateAllocations'])
            ->middleware('permission:subactivity.edit')
            ->name('subactivities.allocations.update');

        Route::delete('subactivities/{subactivity}', [SubActivityController::class, 'destroy'])
            ->middleware('permission:subactivity.delete')
            ->name('subactivities.destroy');


        /* =====================================================
         | STRUCTURE: ALLOCATIONS
         ===================================================== */

        // Route::get('allocations', [AllocationController::class, 'index'])
        //     ->middleware('permission:allocation.view')
        //     ->name('allocations.index');

        // Route::get('allocations/{allocation}', [AllocationController::class, 'show'])
        //     ->middleware('permission:allocation.view')
        //     ->name('allocations.show');

        // Route::resource('allocations', AllocationController::class)
        //     ->middleware('permission:allocation.manage')
        //     ->except(['index', 'show']);


        /* =====================================================
         | REPORTS (READ-ONLY)
         ===================================================== */

        Route::get('reports', [BudgetReportController::class, 'index'])
            ->middleware('permission:budget.reports.view')
            ->name('reports.index');

        Route::get('reports/program/{program}', [BudgetReportController::class, 'programReport'])
            ->middleware('permission:program.report')
            ->name('reports.program');

        Route::get('reports/project/{project}', [BudgetReportController::class, 'projectReport'])
            ->middleware('permission:project.report')
            ->name('reports.project');

        Route::get('reports/activity/{activity}', [BudgetReportController::class, 'activityReport'])
            ->middleware('permission:activity.report')
            ->name('reports.activity');


        /* =====================================================
         | EXECUTIVE SUMMARY
         ===================================================== */

        Route::get('budget-summary/dashboard', [AllocationSummaryController::class, 'dashboard'])
            ->middleware('permission:budget.summary.view')
            ->name('summary.dashboard');

        Route::get('budget-summary/executive', [AllocationSummaryController::class, 'executiveReports'])
            ->middleware('permission:budget.summary.view')
            ->name('summary.executive');


        Route::get('reports/export/pdf/{program}',
            [BudgetReportController::class, 'exportProgramPdf']
        )->middleware('permission:program.report')
        ->name('reports.export.pdf');

        Route::get('reports/export/excel/{program}',
            [BudgetReportController::class, 'exportProgramExcel']
        )->middleware('permission:program.report')
        ->name('reports.export.excel');




    });




Route::middleware(['auth', 'verified'])->group(function () {

    /* =====================================================
     | DASHBOARD (ROLE / PERMISSION BASED)
     ===================================================== */

    Route::middleware('permission:dashboard.access')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
    });


    /* =====================================================
     | USER PROFILE (SELF-SERVICE)
     | No extra permission needed
     ===================================================== */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /* =====================================================
     | PASSWORD MANAGEMENT (SELF-SERVICE)
     | No extra permission needed
     ===================================================== */

    Route::get('/change-password', [ChangePasswordController::class, 'show'])
        ->name('password.change.form');

    Route::post('/change-password', [ChangePasswordController::class, 'update'])
        ->name('password.change.update');
});


/* =====================================================
 | COMMITMENTS – AJAX SUPPORT
 ===================================================== */


// Route::middleware(['auth'])->prefix('procurements')->group(function () {

//     /* ===============================
//      | PROCUREMENT CRUD
//      =============================== */
//     Route::get('/', [ProcurementController::class, 'index'])
//         ->name('procurements.index');

//     Route::get('/create', [ProcurementController::class, 'create'])
//         ->name('procurements.create');
//         // ->middleware('can:procurement.create');

//     Route::post('/', [ProcurementController::class, 'store'])
//         ->name('procurements.store');
//         // ->middleware('can:procurement.create');

//     Route::get('/{procurement}', [ProcurementController::class, 'show'])
//          ->name('procurements.show');

// });



// Route::post('/__route_test', function () {
//     return 'ROUTES LOADED';
// });

// Route::middleware('auth')
//     ->prefix('procurements')
//     ->name('procurements.')
//     ->controller(ProcurementWorkflowController::class)
//     ->group(function () {

//         Route::post('{procurement}/approve', 'approve')->name('approve');
//         Route::post('{procurement}/publish', 'publish')->name('publish');
//         Route::post('{procurement}/close', 'close')->name('close');
//         Route::post('{procurement}/award', 'award')->name('award');
// });

Route::middleware(['auth'])
    ->prefix('procurements')
    ->name('procurements.')
    ->group(function () {

        /* ===============================
         | WORKFLOW ACTIONS (MUST BE FIRST)
         =============================== */

        Route::post('{procurement}/approve',
            [ProcurementWorkflowController::class, 'approve']
        )->name('approve');

        Route::post('{procurement}/publish',
            [ProcurementWorkflowController::class, 'publish']
        )->name('publish');

        Route::post('{procurement}/close',
            [ProcurementWorkflowController::class, 'close']
        )->name('close');

        Route::post('{procurement}/award',
            [ProcurementWorkflowController::class, 'award']
        )->name('award');


        /* ===============================
         | PROCUREMENT CRUD
         =============================== */

        Route::get('/', [ProcurementController::class, 'index'])
            ->name('index');

        Route::get('/create', [ProcurementController::class, 'create'])
            ->name('create');

        Route::post('/', [ProcurementController::class, 'store'])
            ->name('store');

        // ⚠️ GENERIC ROUTE MUST ALWAYS BE LAST
        Route::get('/{procurement}', [ProcurementController::class, 'show'])
            ->name('show');
    });


    use App\Http\Controllers\Procurement\ProcurementStatusController;

Route::middleware(['auth'])
    ->prefix('procurement-status')
    ->name('statusProcurement.')
    ->group(function () {

        Route::post('{procurement}/submit',
            [ProcurementStatusController::class, 'submit']
        )->name('submit');

        Route::post('{procurement}/approve',
            [ProcurementStatusController::class, 'approve']
        )->name('approve');

        Route::post('{procurement}/reject',
            [ProcurementStatusController::class, 'reject']
        )->name('reject');

        Route::post('{procurement}/publish',
            [ProcurementStatusController::class, 'publish']
        )->name('publish');

        Route::post('{procurement}/close',
            [ProcurementStatusController::class, 'close']
        )->name('close');

        Route::post('{procurement}/award',
            [ProcurementStatusController::class, 'award']
        )->name('award');
    });



Route::middleware(['auth', 'permission:forms.manage'])
    ->prefix('procurement/forms')
    ->group(function () {

        /* ===============================
           FORMS
           =============================== */
        Route::get('/', [DynamicFormController::class, 'index'])
            ->name('forms.index');

        Route::get('/create', [DynamicFormController::class, 'create'])
            ->name('forms.create');

        Route::post('/', [DynamicFormController::class, 'store'])
            ->name('forms.store');

        Route::get('/{form}/edit', [DynamicFormController::class, 'edit'])
            ->name('forms.edit');

        /* ===============================
           FORM FIELDS (BUILDER)
           =============================== */
        Route::post(
            '/{form}/fields',
            [DynamicFormFieldController::class, 'store']
        )->name('forms.fields.store');

        Route::delete(
            '/fields/{field}',
            [DynamicFormFieldController::class, 'destroy']
        )->name('forms.fields.destroy');

        Route::post('{form}/submit', [DynamicFormController::class, 'submit'])
            ->middleware('permission:forms.submit')
            ->name('forms.submit');

        Route::post('{form}/approve', [DynamicFormController::class, 'approve'])
            ->middleware('permission:forms.approve')
            ->name('forms.approve');

        Route::post('{form}/reject', [DynamicFormController::class, 'reject'])
            ->middleware('permission:forms.reject')
            ->name('forms.reject');


        Route::get('forms/attach',
            [ProcurementFormAssignmentController::class, 'create']
        )->name('procurements.forms.attach');

        Route::post('forms/attach',
            [ProcurementFormAssignmentController::class, 'store']
        )->name('procurements.forms.store');



         // 🔗 ATTACH FORM TO PROCUREMENT
        Route::post('attach-form', [ProcurementController::class, 'attachForm'])
            ->name('attach-form');

});


Route::middleware(['auth'])
    ->prefix('procurement/submissions')
    ->group(function () {

        Route::get(
            '/form/{form}/create',
            [FormSubmissionController::class, 'create']
        )->name('submissions.create');

        Route::post(
            '/form/{form}',
            [FormSubmissionController::class, 'store']
        )->name('submissions.store');

        Route::get(
            '/{submission}',
            [FormSubmissionController::class, 'show']
        )->name('submissions.show');

});






Route::middleware(['auth', 'can:procurement.audit'])
    ->prefix('procurement/audit')
    ->group(function () {

        Route::get(
            '/',
            [ProcurementAuditController::class, 'index']
        )->name('procurement.audit.index');

});


Route::prefix('procurement/submissions')
    ->middleware(['auth'])
    ->group(function () {

        // List submissions
        Route::get('/', [ProcurementSubmissionController::class, 'index'])
            // ->middleware('can:procurement.view')
            ->name('procurement.submissions.index');

        // View submission details
        Route::get('/{submission}', [ProcurementSubmissionController::class, 'show'])
            // ->middleware('can:procurement.view')
            ->name('procurement.submissions.show');
});



// todays code
Route::middleware(['auth'])
    ->prefix('prescreening/templates')
    ->name('prescreening.templates.')
    ->group(function () {

        Route::get('/', [PrescreeningTemplateController::class, 'index'])
            ->middleware('permission:prescreening.manage')
            ->name('index');

        Route::get('/create', [PrescreeningTemplateController::class, 'create'])
            ->middleware('permission:prescreening.manage')
            ->name('create');

        Route::post('/', [PrescreeningTemplateController::class, 'store'])
            ->middleware('permission:prescreening.manage')
            ->name('store');

        Route::get('/{template}', [PrescreeningTemplateController::class, 'show'])
            ->middleware('permission:prescreening.manage')
            ->name('show');

        Route::get('/{template}/edit', [PrescreeningTemplateController::class, 'edit'])
            ->middleware('permission:prescreening.manage')
            ->name('edit');

        Route::put('/{template}', [PrescreeningTemplateController::class, 'update'])
            ->middleware('permission:prescreening.manage')
            ->name('update');
    });

Route::middleware(['auth'])
    ->prefix('prescreening/templates/{template}')
    ->name('prescreening.criteria.')
    ->group(function () {

        Route::get('/criteria', [PrescreeningCriterionController::class, 'index'])
            ->middleware('permission:prescreening.manage')
            ->name('index');

        Route::get('/criteria/create', [PrescreeningCriterionController::class, 'create'])
            ->middleware('permission:prescreening.manage')
            ->name('create');

        Route::post('/criteria', [PrescreeningCriterionController::class, 'store'])
            ->middleware('permission:prescreening.manage')
            ->name('store');

        Route::get('/criteria/{criterion}', [PrescreeningCriterionController::class, 'show'])
            ->middleware('permission:prescreening.manage')
            ->name('show');

        Route::get('/criteria/{criterion}/edit', [PrescreeningCriterionController::class, 'edit'])
            ->middleware('permission:prescreening.manage')
            ->name('edit');

        Route::put('/criteria/{criterion}', [PrescreeningCriterionController::class, 'update'])
            ->middleware('permission:prescreening.manage')
            ->name('update');
    });


Route::middleware(['auth'])
    ->prefix('procurements/{procurement}/prescreening')
    ->group(function () {

        Route::get('/', [PrescreeningAssignmentController::class, 'edit'])
            ->middleware('permission:prescreening.manage')
            ->name('procurements.prescreening.edit');

        Route::post('/', [PrescreeningAssignmentController::class, 'store'])
            ->middleware('permission:prescreening.manage')
            ->name('procurements.prescreening.store');
    });






Route::middleware(['auth'])
    ->prefix('prescreening')
    ->group(function () {

        Route::get(
            'submissions',
            [PrescreeningEvaluationController::class, 'index']
        )->middleware('permission:prescreening.evaluate')
         ->name('prescreening.submissions.index');

        Route::get(
            'submissions/{submission}',
            [PrescreeningEvaluationController::class, 'show']
        )->middleware('permission:prescreening.evaluate')
         ->name('prescreening.submissions.show');

        Route::post(
            'submissions/{submission}',
            [PrescreeningEvaluationController::class, 'store']
        )->middleware('permission:prescreening.evaluate')
         ->name('prescreening.submissions.store');

        // ✅ NEW: REQUEST REWORK
        Route::post(
            'submissions/{submission}/rework',
            [PrescreeningEvaluationController::class, 'requestRework']
        )->middleware('permission:prescreening.request_rework')
         ->name('prescreening.submissions.rework');
    });

Route::middleware(['auth', 'permission:prescreening.evaluate'])
    ->get('prescreening/my-assignments', [PrescreeningUserAssignmentController::class, 'myAssignments'])
    ->name('prescreening.assignments.my');



Route::middleware(['auth'])
    ->prefix('prescreening/assignments')
    ->group(function () {

        Route::get('/',
            [PrescreeningUserAssignmentController::class, 'index']
        )->middleware('permission:prescreening.manage')
         ->name('prescreening.assignments.index');

        Route::get('/{procurement}',
            [PrescreeningUserAssignmentController::class, 'edit']
        )->middleware('permission:prescreening.manage')
         ->name('prescreening.assignments.edit');

        Route::post('/{procurement}',
            [PrescreeningUserAssignmentController::class, 'store']
        )->middleware('permission:prescreening.manage')
         ->name('prescreening.assignments.store');
    });










    /*
|--------------------------------------------------------------------------
| PUBLIC PROCUREMENT PORTAL
|--------------------------------------------------------------------------
| Accessible without authentication
*/
 /*
|--------------------------------------------------------------------------
| PUBLIC PROCUREMENT APPLICATIONS
|--------------------------------------------------------------------------
*/

Route::prefix('public/procurement')->group(function () {

    Route::get('/', [PublicProcurementController::class, 'index'])
        ->name('public.procurement.index');

    Route::get('/{procurement}', [PublicProcurementController::class, 'show'])
        ->name('public.procurement.show');

    Route::post('/{procurement}/apply', [PublicProcurementController::class, 'submit'])
        ->name('public.procurement.apply');

});


use App\Http\Controllers\EvaluationSectionController;
use App\Http\Controllers\EvaluationCriteriaController;


/*
|--------------------------------------------------------------------------
| EVALUATION CONFIGURATION (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:evaluations.manage'])
    ->prefix('evals/config')
    ->name('evals.cfg.')
    ->group(function () {

        /* ===============================
         | MAIN
         =============================== */
        Route::get('/', [EvaluationController::class, 'index'])
            ->name('index');

        Route::get('/new', [EvaluationController::class, 'create'])
            ->name('new');

        Route::post('/store', [EvaluationController::class, 'store'])
            ->name('store');

        /* ===============================
         | SINGLE EVALUATION
         =============================== */
        Route::get('/{evaluation}', [EvaluationController::class, 'show'])
            ->whereNumber('evaluation')
            ->name('show');

        Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])
            ->whereNumber('evaluation')
            ->name('edit');

        Route::put('/{evaluation}/update', [EvaluationController::class, 'update'])
            ->whereNumber('evaluation')
            ->name('update');

        Route::delete('/{evaluation}/delete', [EvaluationController::class, 'destroy'])
            ->whereNumber('evaluation')
            ->name('delete');

        /* ===============================
         | SECTIONS
         =============================== */
        Route::post('/{evaluation}/sec/add',
            [EvaluationSectionController::class, 'store']
        )
            ->whereNumber('evaluation')
            ->name('sec.add');

        Route::put('/sec/{section}/upd',
            [EvaluationSectionController::class, 'update']
        )
            ->whereNumber('section')
            ->name('sec.upd');

        Route::delete('/sec/{section}/del',
            [EvaluationSectionController::class, 'destroy']
        )
            ->whereNumber('section')
            ->name('sec.del');

        /* ===============================
         | CRITERIA
         =============================== */
        Route::post('/sec/{section}/crt/add',
            [EvaluationCriteriaController::class, 'store']
        )
            ->whereNumber('section')
            ->name('crt.add');

        Route::put('/crt/{criteria}/upd',
            [EvaluationCriteriaController::class, 'update']
        )
            ->whereNumber('criteria')
            ->name('crt.upd');

        Route::delete('/crt/{criteria}/del',
            [EvaluationCriteriaController::class, 'destroy']
        )
            ->whereNumber('criteria')
            ->name('crt.del');

       Route::get(
            '/panel/pdf/{submission}',
            [EvaluationPanelPdfController::class, 'single']
        )->name('panel.pdf.single');

        Route::get(
            '/panel/pdf/procurement/{procurement}',
            [EvaluationPanelPdfController::class, 'bulk']
        )->name('panel.pdf.bulk');

});


    /*
|--------------------------------------------------------------------------
| PROCUREMENT → EVALUATION LINKING (STILL PHASE 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:evaluations.manage'])
    ->prefix('procurements')
    ->name('procurements.')
    ->group(function () {

        Route::get('/{procurement}/eval/assign',
            [ProcurementEvaluationController::class, 'create']
        )
            ->whereNumber('procurement')
            ->name('eval.assign');

        Route::post('/{procurement}/eval/assign',
            [ProcurementEvaluationController::class, 'store']
        )
            ->whereNumber('procurement')
            ->name('eval.assign.store');
});


use App\Http\Controllers\EvaluationSubmissionController;
use App\Http\Controllers\EvaluationScoringController;

/*
|--------------------------------------------------------------------------
| EVALUATOR SIDE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:evaluations.evaluate'])
    ->prefix('my-evaluations')
    ->name('my.eval.')
    ->group(function () {

        // List assignments
        Route::get('/', [EvaluationSubmissionController::class, 'myEvaluations'])
            ->name('index');

        // Start / continue evaluation
        Route::get('/{assignment}/start', [EvaluationSubmissionController::class, 'start'])
            ->name('start');

        // ✅ SAVE SCORES (AUTOSAVE / DRAFT)
        Route::post('/{assignment}/save-scores', [EvaluationSubmissionController::class, 'saveScores'])
            ->name('saveScores');

        // Submit final evaluation
        Route::post('/submit/{assignment}', [EvaluationSubmissionController::class, 'submit'])
            ->name('submit');

        // View submitted evaluation
        Route::get('/{assignment}/view', [EvaluationSubmissionController::class, 'view'])
            ->name('view');

        // Compare evaluators
        Route::get('/{assignment}/compare', [EvaluationSubmissionController::class, 'compare'])
            ->name('compare');

        // Sidebar-safe compare redirect
        Route::get('/compare', [EvaluationSubmissionController::class, 'compareRedirect'])
            ->name('compare.redirect');

        // Send evaluation for rework
        Route::post('/evaluations/{submission}/rework', [EvaluationSubmissionController::class, 'sendForRework'])
            ->name('evaluations.rework');
    });



/*
|--------------------------------------------------------------------------
| SCORING (AJAX)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:evaluations.evaluate'])
    ->prefix('evaluation/score')
    ->name('eval.score.')
    ->group(function () {

        Route::post('/criteria',
            [EvaluationScoringController::class, 'saveCriteriaScore']
        )->name('criteria');

        Route::post('/section',
            [EvaluationScoringController::class, 'saveSectionNotes']
        )->name('section');
    });

/*
|--------------------------------------------------------------------------
| ADMIN / PROCUREMENT SIDE
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'permission:evaluations.manage'])
    ->prefix('evaluation-assignments')
    ->name('eval.assign.')
    ->group(function () {

        /* ===============================
         | ASSIGNMENT HUB
         =============================== */
        Route::get('/',
            [EvaluationAssignmentController::class, 'hub']
        )->name('hub');

        Route::post('/store',
            [EvaluationAssignmentController::class, 'store']
        )->name('store');

        Route::delete('/{assignment}',
            [EvaluationAssignmentController::class, 'destroy']
        )->name('destroy');
});

Route::middleware(['auth', 'permission:evaluations.evaluate'])
    ->prefix('evaluation-assignments')
    ->name('eval.assign.')
    ->group(function () {
        /* ===============================
         | EVALUATOR WORKFLOW
         =============================== */

        // List applicants for this assignment
        Route::get('/{assignment}/applicants',
            [EvaluationSubmissionController::class, 'myEvaluations']
        )->name('applicants');

        // Start / continue evaluation (PER APPLICANT)
        Route::get('/{assignment}/start/{applicant}',
            [EvaluationSubmissionController::class, 'start']
        )->name('start');

        // Autosave scores
        Route::post('/{assignment}/save/{applicant}',
            [EvaluationSubmissionController::class, 'saveScores']
        )->name('save');

        // Final submit
        Route::post('/{assignment}/submit/{applicant}',
            [EvaluationSubmissionController::class, 'submit']
        )->name('submit');

        // Read-only view
        Route::get('/{assignment}/view/{applicant}',
            [EvaluationSubmissionController::class, 'view']
        )->name('view');
    });

Route::middleware(['auth', 'permission:evaluations.evaluate'])
    ->prefix('panel-evaluations')
    ->name('eval.panel.')
    ->group(function () {

        // Panel Evaluation Dashboard
        Route::get('/',
            [EvaluationSubmissionController::class, 'panelHub']
        )->name('index');

        // (optional, later)
        // Route::get('/data', [EvaluationSubmissionController::class, 'panelData'])
        //     ->name('data');
});


use App\Http\Controllers\{
    SiteVisitController,
    SiteVisitAssignmentController,
    SiteVisitGroupController,
    SiteVisitObservationController,
    SiteVisitMediaController,
    ProcurementSiteVisitReportController
};

Route::prefix('site-visits')->name('site-visits.')->group(function () {

    /* =========================
     | MAIN
     ========================= */
    Route::get('/', [SiteVisitController::class, 'index'])
        ->name('index');

    Route::get('/create', [SiteVisitController::class, 'create'])
        ->name('create');

    Route::post('/', [SiteVisitController::class, 'store'])
        ->name('store');

    Route::get('/{siteVisit}', [SiteVisitController::class, 'show'])
        ->name('show');


    /* =========================
     | ASSIGNMENT (ADMIN)
     ========================= */
    Route::post('/{siteVisit}/assign-individual',
        [SiteVisitAssignmentController::class, 'assignIndividual']
    )->name('assign.individual');

    Route::post('/{siteVisit}/assign-group',
        [SiteVisitGroupController::class, 'assignGroup']
    )->name('assign.group');


    /* =========================
     | OBSERVATIONS (LEADER)
     ========================= */
    Route::get('/{siteVisit}/observations/create',
        [SiteVisitObservationController::class, 'create']
    )->name('observations.create');

    Route::post('/{siteVisit}/observations',
        [SiteVisitObservationController::class, 'store']
    )->name('observations.store');


    /* =========================
     | MEDIA
     ========================= */
    Route::post('/{siteVisit}/media',
        [SiteVisitMediaController::class, 'store']
    )->name('media.store');


    /* =========================
     | SUBMISSION
     ========================= */
    Route::post('/{siteVisit}/submit',
        [SiteVisitController::class, 'submit']
    )->name('submit');


    /* =========================
     | APPROVAL
     ========================= */
    Route::post('/{siteVisit}/approve',
        [SiteVisitController::class, 'approve']
    )->name('approve');



    Route::get(
    '/procurements/{procurement}/site-visit-report',
    [ProcurementSiteVisitReportController::class, 'show']
    )->name('procurements.site-visit-report');


    Route::get(
    '/reports/site-visits',
    [ProcurementSiteVisitReportController::class, 'index']
)->name('reports.index');




});












Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact');
Route::get('/bids/{project}', [LandingPageController::class, 'showBid'])->name('landing.show');
Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluations.index');
Route::get('/create/{applicant_id}', [EvaluationController::class, 'create'])
    ->name('evaluations.create');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::middleware(['auth', 'permission:prescreening.reports.view_all'])
    ->prefix('reports/prescreening')
    ->name('reports.prescreening.')
    ->group(function () {
        Route::get('/', [PrescreeningReportController::class, 'index'])->name('index');
        Route::get('/submission/{submission}', [PrescreeningReportController::class, 'submission'])->name('submission');
        Route::get('/submission/{submission}/pdf', [PrescreeningReportController::class, 'submissionPdf'])->name('submission.pdf');
        Route::get('/procurement/{procurement}', [PrescreeningReportController::class, 'procurement'])->name('procurement');
        Route::get('/procurement/{procurement}/pdf', [PrescreeningReportController::class, 'procurementPdf'])->name('procurement.pdf');
        Route::get('/consolidated', [PrescreeningReportController::class, 'consolidated'])->name('consolidated');
        Route::get('/consolidated/pdf', [PrescreeningReportController::class, 'consolidatedPdf'])->name('consolidated.pdf');
    });

Route::middleware(['auth', 'permission:evaluations.view_all'])
    ->prefix('reports/evaluations')
    ->name('reports.evaluations.')
    ->group(function () {
        Route::get('/', [EvaluationReportController::class, 'index'])->name('index');
        Route::get('/submission/{submission}', [EvaluationReportController::class, 'submission'])->name('submission');
        Route::get('/submission/{submission}/pdf', [EvaluationReportController::class, 'submissionPdf'])->name('submission.pdf');
        Route::get('/procurement/{procurement}', [EvaluationReportController::class, 'procurement'])->name('procurement');
        Route::get('/procurement/{procurement}/pdf', [EvaluationReportController::class, 'procurementPdf'])->name('procurement.pdf');
        Route::get('/consolidated', [EvaluationReportController::class, 'consolidated'])->name('consolidated');
        Route::get('/consolidated/pdf', [EvaluationReportController::class, 'consolidatedPdf'])->name('consolidated.pdf');
    });

Route::get('/callforproposal', [ApplicantController::class, 'create'])->name('applicants.create');
Route::get('/faq', [ApplicantController::class, 'faq'])->name('applicants.faq');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicants.store');
Route::get('/events', [ApplicantController::class, 'events'])->name('events');

Route::middleware(['auth', 'permission:system.audit.view'])
    ->prefix('system/audit')
    ->name('system.audit.')
    ->group(function () {
        Route::get('/', [SystemAuditController::class, 'index'])->name('index');
    });


require __DIR__ . '/auth.php';
