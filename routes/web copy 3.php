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
    PrescreeningCriteriaController,
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
    AllocationController,
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



 Route::middleware(['auth', 'verified', 'permission:system.access'])
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


Route::middleware(['auth', 'permission:hr.access'])
    ->prefix('hr')
    ->name('hr.')
    ->group(function () {

    /* -------- POSITIONS -------- */
    Route::middleware('permission:hr.positions.view')->get(
        'positions', [HrController::class, 'positions']
    )->name('positions.index');

    Route::middleware('permission:hr.positions.manage')->post(
        'positions', [HrController::class, 'storePosition']
    )->name('positions.store');

    /* -------- VACANCIES -------- */
    Route::middleware('permission:hr.vacancies.view')->group(function () {
        Route::get('vacancies', [HrController::class, 'vacancies'])->name('vacancies.index');
        Route::get('vacancies/{vacancy}/applicants', [HrController::class, 'applicants'])
            ->name('vacancies.applicants');
    });

    Route::middleware('permission:hr.vacancies.manage')->post(
        'vacancies', [HrController::class, 'storeVacancy']
    )->name('vacancies.store');

    Route::middleware('permission:hr.vacancies.workflow')->group(function () {
        Route::post('vacancies/{vacancy}/submit', [HrController::class, 'submitVacancyForApproval'])
            ->name('vacancies.submit');
        Route::post('vacancies/{vacancy}/approve', [HrController::class, 'approveVacancy'])
            ->name('vacancies.approve');
        Route::post('vacancies/{vacancy}/publish', [HrController::class, 'publishVacancy'])
            ->name('vacancies.publish');
        Route::post('vacancies/{vacancy}/close', [HrController::class, 'closeVacancy'])
            ->name('vacancies.close');
    });

    /* -------- APPLICANTS -------- */
    Route::middleware('permission:hr.applicants.view')->get(
        'applicants/{applicant}', [HrController::class, 'showApplicant']
    )->name('applicants.show');

    Route::middleware('permission:hr.applicants.manage')->group(function () {
        Route::post('applicants/{applicant}/shortlist', [HrController::class, 'shortlistApplicant'])
            ->name('applicants.shortlist');
        Route::post('applicants/{applicant}/reject', [HrController::class, 'rejectApplicant'])
            ->name('applicants.reject');
        Route::post('applicants/{applicant}/schedule-interview',
            [HrController::class, 'scheduleInterview'])
            ->name('applicants.interview');
    });

    Route::middleware('permission:hr.applicants.hire')->post(
        'applicants/{applicant}/hire', [HrController::class, 'hireApplicant']
    )->name('applicants.hire');

    /* -------- AI & ANALYTICS -------- */
    Route::middleware('permission:hr.ai.score')->group(function () {
        Route::post('applicants/{applicant}/score-ai', [HrController::class, 'scoreApplicantAI'])
            ->name('applicants.score');
        Route::post('vacancies/{vacancy}/bulk-score', [HrController::class, 'bulkScoreApplicants'])
            ->name('vacancies.bulkScore');
    });

    Route::middleware('permission:hr.analytics.view')->get(
        'analytics', [HrController::class, 'analytics']
    )->name('analytics');
});


Route::middleware(['auth', 'permission:finance.access'])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {

    /* -------- RESOURCES -------- */
    Route::middleware('permission:finance.resources.manage')
        ->prefix('resources')->group(function () {

        Route::get('categories', [BudgetCommitmentController::class, 'resourceCategories'])
            ->name('resources.categories.index');
        Route::post('categories', [BudgetCommitmentController::class, 'storeResourceCategory'])
            ->name('resources.categories.store');

        Route::get('items', [BudgetCommitmentController::class, 'resources'])
            ->name('resources.items.index');
        Route::post('items', [BudgetCommitmentController::class, 'storeResource'])
            ->name('resources.items.store');
    });

    /* -------- FUNDERS -------- */
    Route::middleware('permission:finance.funders.manage')
        ->resource('funders', FunderController::class)->except(['destroy']);

    /* ===================== Department ===================== */
 Route::prefix('departments')->as('departments.')->group(function () {

            Route::get('/', [DepartmentController::class, 'index'])
                ->name('index');

            Route::get('/create', [DepartmentController::class, 'create'])
                ->name('create');

            Route::post('/', [DepartmentController::class, 'store'])
                ->name('store');

            Route::get('/{department}', [DepartmentController::class, 'show'])
                ->name('show');

            Route::get('/{department}/edit', [DepartmentController::class, 'edit'])
                ->name('edit');

            Route::put('/{department}', [DepartmentController::class, 'update'])
                ->name('update');

            /* ===== Assign Department Head ===== */
            Route::post(
                '/{department}/assign-head',
                [DepartmentController::class, 'assignHead']
            )->name('assign-head');
        });

    /* -------- PROGRAM FUNDING -------- */
    Route::middleware('permission:finance.program_funding.manage')
        ->resource('program-funding', ProgramFundingController::class);

    /* -------- COMMITMENTS -------- */
    Route::middleware('permission:finance.commitments.manage')
        ->resource('commitments', BudgetCommitmentController::class);

    /* -------- EXECUTION -------- */
    Route::middleware('permission:finance.execution.view')->get(
        'execution/dashboard', [MasterDashboard::class, 'executionDashboard']
    )->name('execution.dashboard');
});


 Route::middleware(['auth'])
    ->prefix('budget')
    ->name('budget.')
    ->group(function () {



        /* =====================================================
         | PROGRAMS
         | RBAC handled inside ProgramController
         ===================================================== */

        // LIST
        Route::get('programs', [ProgramController::class, 'index'])
            ->name('programs.index');

        // CREATE
        Route::get('programs/create', [ProgramController::class, 'create'])
            ->name('programs.create');

        // STORE
        Route::post('programs', [ProgramController::class, 'store'])
            ->name('programs.store');

        // SHOW
        Route::get('programs/{program}', [ProgramController::class, 'show'])
            ->name('programs.show');

        // EDIT
        Route::get('programs/{program}/edit', [ProgramController::class, 'edit'])
            ->name('programs.edit');

        // UPDATE
        Route::put('programs/{program}', [ProgramController::class, 'update'])
            ->name('programs.update');

        // DELETE
        Route::delete('programs/{program}', [ProgramController::class, 'destroy'])
            ->name('programs.destroy');

        /* =====================================================
        | STRUCTURE: SECTORS
        ===================================================== */
        /* ===================== SECTORS ===================== */

        /* VIEW */
        Route::get('sectors', [SectorController::class, 'index'])
            ->middleware('permission:sector.view')
            ->name('sectors.index');

        /* CREATE */
        Route::get('sectors/create', [SectorController::class, 'create'])
            ->middleware('permission:sector.create')
            ->name('sectors.create');

        Route::post('sectors', [SectorController::class, 'store'])
            ->middleware('permission:sector.create')
            ->name('sectors.store');

        /* EDIT */
        Route::get('sectors/{sector}/edit', [SectorController::class, 'edit'])
            ->middleware('permission:sector.edit')
            ->name('sectors.edit');

        Route::put('sectors/{sector}', [SectorController::class, 'update'])
            ->middleware('permission:sector.edit')
            ->name('sectors.update');

        /* DELETE */
        Route::delete('sectors/{sector}', [SectorController::class, 'destroy'])
            ->middleware('permission:sector.delete')
            ->name('sectors.destroy');





        /* =====================================================
        | STRUCTURE: PROGRAMS
        ===================================================== */

        // VIEW



            /* =====================================================
            | STRUCTURE: PROJECTS
            ===================================================== */

            // VIEW
            /* =====================================================
        | PROJECTS
        ===================================================== */
        // LIST
        Route::get('projects', [ProjectController::class, 'index'])
            ->middleware('permission:project.view')
            ->name('projects.index');

        // CREATE ( MUST COME BEFORE {project})
        Route::get('projects/create', [ProjectController::class, 'create'])
            ->middleware('permission:project.create')
            ->name('projects.create');

        // STORE
        Route::post('projects', [ProjectController::class, 'store'])
            ->middleware('permission:project.create')
            ->name('projects.store');

        // SHOW
       Route::get('projects/{project}', [ProjectController::class, 'show'])
            ->middleware('permission:project.view')
            ->name('projects.show');



        // EDIT
        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])
            ->middleware('permission:project.edit')
            ->name('projects.edit');

        // UPDATE
        Route::put('projects/{project}', [ProjectController::class, 'update'])
            ->middleware('permission:project.edit')
            ->name('projects.update');

        // DELETE
        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])
            ->middleware('permission:project.delete')
            ->name('projects.destroy');




            /* =====================================================
            | ACTIVITIES
            ===================================================== */

            // VIEW
            /* =====================================================
            | ACTIVITIES
            ===================================================== */
            /*
            |--------------------------------------------------------------------------
            | ACTIVITIES
            |--------------------------------------------------------------------------
            */

            /* ===================== VIEW ===================== */
        Route::get('activities', [ActivityController::class, 'index'])
            ->middleware('permission:activities.view')
            ->name('activities.index');

        Route::get('activities/{activity}', [ActivityController::class, 'show'])
            ->middleware('permission:activities.view')
            ->name('activities.show');


        /* ===================== CREATE (PROJECT-SCOPED) ===================== */
        Route::get('activities/create/{project}', [ActivityController::class, 'create'])
            ->middleware('permission:activities.create')
            ->name('activities.create');

        Route::post('activities', [ActivityController::class, 'store'])
            ->middleware('permission:activities.create')
            ->name('activities.store');


        /* ===================== EDIT ===================== */
        Route::get('activities/{activity}/edit', [ActivityController::class, 'editAllocations'])
            ->middleware('permission:activities.edit')
            ->name('activities.edit');

        Route::put('activities/{activity}', [ActivityController::class, 'update'])
            ->middleware('permission:activities.edit')
            ->name('activities.update');


        /* ===================== DELETE ===================== */
        Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])
            ->middleware('permission:activities.delete')
            ->name('activities.destroy');





    /* =====================================================
     | SUB-ACTIVITIES
     ===================================================== */

     /*
    |--------------------------------------------------------------------------
    | SUB-ACTIVITIES
    |--------------------------------------------------------------------------
    */

/* ===================== VIEW ===================== */
Route::get('subactivities', [SubActivityController::class, 'index'])
    ->middleware('permission:subactivities.view')
    ->name('subactivities.index');

Route::get('subactivities/{subactivity}', [SubActivityController::class, 'show'])
    ->middleware('permission:subactivities.view')
    ->name('subactivities.show');


/* ===================== CREATE ===================== */
Route::get('activities/{activity}/subactivities/create', [SubActivityController::class, 'create'])
    ->middleware('permission:subactivities.create')
    ->name('subactivities.create');

Route::post('subactivities', [SubActivityController::class, 'store'])
    ->middleware('permission:subactivities.create')
    ->name('subactivities.store');


/* ===================== EDIT ===================== */
Route::get('subactivities/{subactivity}/edit', [SubActivityController::class, 'edit'])
    ->middleware('permission:subactivities.edit')
    ->name('subactivities.edit');

Route::put('subactivities/{subactivity}', [SubActivityController::class, 'update'])
    ->middleware('permission:subactivities.edit')
    ->name('subactivities.update');


/* ===================== ALLOCATION MANAGEMENT ===================== */
Route::get('subactivities/{subactivity}/edit-allocations', [SubActivityController::class, 'editAllocations'])
    ->middleware('permission:subactivity.edit')
    ->name('subactivities.allocations.edit');

Route::post('subactivities/{subactivity}/update-allocations', [SubActivityController::class, 'updateAllocations'])
    ->middleware('permission:subactivity.edit')
    ->name('subactivities.allocations.update');


/* ===================== DELETE ===================== */
Route::delete('subactivities/{subactivity}', [SubActivityController::class, 'destroy'])
    ->middleware('permission:subactivity.delete')
    ->name('subactivities.destroy');



    /* =====================================================
     | ALLOCATIONS
     ===================================================== */

    // VIEW
    Route::get('allocations', [AllocationController::class, 'index'])
        ->middleware('permission:allocation.view')
        ->name('allocations.index');

    Route::get('allocations/{allocation}', [AllocationController::class, 'show'])
        ->middleware('permission:allocation.view')
        ->name('allocations.show');

    // MANAGE
    Route::resource('allocations', AllocationController::class)
        ->middleware('permission:allocation.manage')
        ->except(['index', 'show']);


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
     | SUMMARY (EXECUTIVE)
     ===================================================== */

    Route::get('budget-summary/dashboard', [AllocationSummaryController::class, 'dashboard'])
        ->middleware('permission:budget.summary.view')
        ->name('summary.dashboard');

    Route::get('budget-summary/executive', [AllocationSummaryController::class, 'executiveReports'])
        ->middleware('permission:budget.summary.view')
        ->name('summary.executive');
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



Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact');
Route::get('/bids/{project}', [LandingPageController::class, 'showBid'])->name('landing.show');
Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluations.index');
Route::get('/create/{applicant_id}', [EvaluationController::class, 'create'])
    ->name('evaluations.create');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/callforproposal', [ApplicantController::class, 'create'])->name('applicants.create');
Route::get('/faq', [ApplicantController::class, 'faq'])->name('applicants.faq');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicants.store');
Route::get('/events', [ApplicantController::class, 'events'])->name('events');


require __DIR__ . '/auth.php';
