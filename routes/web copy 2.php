<?php

use Illuminate\Support\Facades\Route;

// MAIN CONTROLLERS
use App\Http\Controllers\ThinkDatasetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\PrescreeningCriteriaController;
use App\Http\Controllers\PublicCheckController;
use App\Http\Controllers\SiteVisitEvaluationController;
use App\Http\Controllers\ProjectBudgetController;

 // BUDGET MODULE CONTROLLERS
use App\Http\Controllers\BudgetAllocationController;
use App\Http\Controllers\BudgetReportController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SubActivityController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\AllocationSummaryController;
use App\Http\Controllers\BudgetCommitmentController;



 use App\Http\Controllers\{
    DepartmentController,
    FunderController,
    ProgramFundingController,
    MasterDashboard,
    HrPublicController,
    HrController,
    ProgramFundingDocumentController
};



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
        POSITIONS
    ===================================================== */
    Route::get('/positions', [HrController::class, 'positions'])
        ->name('positions.index');

    Route::post('/positions', [HrController::class, 'storePosition'])
        ->name('positions.store');


    /* =====================================================
        VACANCIES
    ===================================================== */
    Route::get('/vacancies', [HrController::class, 'vacancies'])
        ->name('vacancies.index');

    Route::post('/vacancies', [HrController::class, 'storeVacancy'])
        ->name('vacancies.store');


    /* ---------- VACANCY APPROVAL WORKFLOW ---------- */

    Route::post('/vacancies/{vacancy}/submit', [HrController::class, 'submitVacancyForApproval'])
        ->name('vacancies.submit');

    Route::post('/vacancies/{vacancy}/approve', [HrController::class, 'approveVacancy'])
        ->name('vacancies.approve');

    Route::post('/vacancies/{vacancy}/publish', [HrController::class, 'publishVacancy'])
        ->name('vacancies.publish');

    Route::post('/vacancies/{vacancy}/close', [HrController::class, 'closeVacancy'])
        ->name('vacancies.close');


    /* =====================================================
        APPLICATION PORTAL
    ===================================================== */
    Route::get('/vacancies/{vacancy}/applicants', [HrController::class, 'applicants'])
        ->name('vacancies.applicants');

    Route::get('/applicants/{applicant}', [HrController::class, 'showApplicant'])
        ->name('applicants.show');


    /* =====================================================
        AI SCORING
    ===================================================== */

    // Single applicant AI score
    Route::post('/applicants/{applicant}/score-ai', [HrController::class, 'scoreApplicantAI'])
        ->name('applicants.score');

    // Bulk AI scoring (per vacancy)
    Route::post('/vacancies/{vacancy}/bulk-score', [HrController::class, 'bulkScoreApplicants'])
        ->name('vacancies.bulkScore');


    /* =====================================================
        SHORTLIST / REJECT / INTERVIEW
    ===================================================== */

    Route::post('/applicants/{applicant}/shortlist', [HrController::class, 'shortlistApplicant'])
        ->name('applicants.shortlist');

    Route::post('/applicants/{applicant}/reject', [HrController::class, 'rejectApplicant'])
        ->name('applicants.reject');

    Route::post('/applicants/{applicant}/schedule-interview', [HrController::class, 'scheduleInterview'])
        ->name('applicants.interview');


    /* =====================================================
        HIRING
    ===================================================== */

    Route::post('/applicants/{applicant}/hire', [HrController::class, 'hireApplicant'])
        ->name('applicants.hire');


    /* =====================================================
        ANALYTICS
    ===================================================== */

    Route::get('/analytics', [HrController::class, 'analytics'])
        ->name('analytics');

});



Route::middleware(['auth'])
    ->prefix('finance')
    ->as('finance.')
    ->group(function () {



        /* =========================================================
         | RESOURCES (HANDLED BY BudgetCommitmentController)
         ========================================================= */
        Route::prefix('resources')
            ->as('resources.')
            ->group(function () {

                /* -------- CATEGORIES -------- */
                Route::get(
                    '/categories',
                    [BudgetCommitmentController::class, 'resourceCategories']
                )->name('categories.index');

                Route::post(
                    '/categories',
                    [BudgetCommitmentController::class, 'storeResourceCategory']
                )->name('categories.store');

                /* -------- RESOURCE ITEMS -------- */
                Route::get(
                    '/items',
                    [BudgetCommitmentController::class, 'resources']
                )->name('items.index');

                Route::post(
                    '/items',
                    [BudgetCommitmentController::class, 'storeResource']
                )->name('items.store');


                Route::get(
                        '/ajax/resources/{category}',
                        [BudgetCommitmentController::class, 'resourcesByCategory']
                    )->name('ajax.resources');

            });



             /* ===================== FUNDERS ===================== */
        Route::prefix('funders')->as('funders.')->group(function () {

            Route::get('/', [FunderController::class, 'index'])
                ->name('index');

            Route::get('/create', [FunderController::class, 'create'])
                ->name('create');

            Route::post('/', [FunderController::class, 'store'])
                ->name('store');

            Route::get('/{funder}', [FunderController::class, 'show'])
                ->name('show');

            Route::get('/{funder}/edit', [FunderController::class, 'edit'])
                ->name('edit');

            Route::put('/{funder}', [FunderController::class, 'update'])
                ->name('update');
        });
        /* =========================================================
         | STRUCTURE & OWNERSHIP
         ========================================================= */

        /* -------- DEPARTMENTS -------- */

        /* ===================== DEPARTMENTS ===================== */
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

        // Route::prefix('departments')
        //     ->as('departments.')
        //     ->group(function () {

        //         Route::get('/', [DepartmentController::class, 'index'])
        //             ->name('index');

        //         Route::post(
        //             '/{department}/assign-head',
        //             [DepartmentController::class, 'assignHead']
        //         )->name('assign-head');
        //     });

        /* -------- FUNDERS -------- */
        // Route::prefix('funders')
        //     ->as('funders.')
        //     ->group(function () {

        //         Route::get('/', [FunderController::class, 'index'])
        //             ->name('index');
        //     });

        /* =========================================================
         | FUNDING & APPROVALS
         ========================================================= */

        /* -------- PROGRAM FUNDING -------- */
       Route::prefix('program-funding')
    ->as('program-funding.')
    ->group(function () {

        Route::get('/', [ProgramFundingController::class, 'index'])
            ->name('index');

        Route::get('/create', [ProgramFundingController::class, 'create'])
            ->name('create');

        Route::post('/', [ProgramFundingController::class, 'store'])
            ->name('store');

        // ✅ ADD THESE
        Route::get('/{funding}/edit', [ProgramFundingController::class, 'edit'])
            ->name('edit');

        Route::put('/{funding}', [ProgramFundingController::class, 'update'])
            ->name('update');

        Route::get('/{funding}', [ProgramFundingController::class, 'show'])
            ->name('show');

        Route::post('/{funding}/approve', [ProgramFundingController::class, 'approve'])
            ->name('approve');

         Route::post('/{funding}/reject', [ProgramFundingController::class, 'reject'])
            ->name('reject');

            Route::post('/{funding}/submit', [ProgramFundingController::class, 'submit'])
            ->name('submit');
    });



        /* =========================================================
         | BUDGET EXECUTION
         ========================================================= */

        /* -------- BUDGET COMMITMENTS -------- */
        Route::prefix('commitments')
            ->as('commitments.')
            ->group(function () {

                Route::get('/', [BudgetCommitmentController::class, 'index'])
                    ->name('index');

                Route::get('/create', [BudgetCommitmentController::class, 'create'])
                    ->name('create');

                Route::post('/', [BudgetCommitmentController::class, 'store'])
                    ->name('store');

                Route::get('/{commitment}', [BudgetCommitmentController::class, 'show'])
                    ->name('show');

                Route::post('/{commitment}/submit', [BudgetCommitmentController::class, 'submit'])
                    ->name('submit');

                Route::post('/{commitment}/approve', [BudgetCommitmentController::class, 'approve'])
                    ->name('approve');

                Route::post('/{commitment}/cancel', [BudgetCommitmentController::class, 'cancel'])
                    ->name('cancel');

                /* ===== AJAX ===== */
                Route::get('/ajax/projects',
                    [BudgetCommitmentController::class, 'projects']
                )->name('ajax.projects');

                Route::get('/ajax/activities/{project}',
                    [BudgetCommitmentController::class, 'activities']
                )->name('ajax.activities');

                Route::get('/ajax/sub-activities/{activity}',
                    [BudgetCommitmentController::class, 'subActivities']
                )->name('ajax.sub-activities');

                Route::get('/ajax/allocation-years/{level}/{id}',
                    [BudgetCommitmentController::class, 'allocationYears']
                )->name('ajax.allocation-years');

                Route::get('/ajax/remaining-budget',
                    [BudgetCommitmentController::class, 'remainingBudget']
                )->name('ajax.remaining-budget');
            });

        /* =========================================================
         | EXECUTION DASHBOARD & REPORTS
         ========================================================= */

        Route::prefix('execution')
            ->as('execution.')
            ->group(function () {

                Route::get(
                    '/dashboard',
                    [MasterDashboard::class, 'executionDashboard']
                )->name('dashboard');


            });
    });



    Route::prefix('execution')
            ->as('execution.')
            ->group(function () {

                Route::get(
                    '/dashboard',
                    [MasterDashboard::class, 'executionDashboard']
                )->name('dashboard');


            });

/*
|--------------------------------------------------------------------------
| BUDGET MANAGEMENT (CRUD + REPORTS)
|--------------------------------------------------------------------------
*/



Route::middleware(['auth'])->prefix('budget')->group(function () {

    // SECTOR / PROGRAM / PROJECT MANAGEMENT
    Route::resource('sectors', SectorController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('projects', ProjectController::class);

    /*
    |--------------------------------------------------------------------------
    | ACTIVITIES — CUSTOM ROUTES (CREATE, ALLOCATIONS)
    |--------------------------------------------------------------------------
    */

    // CREATE ACTIVITY INSIDE SPECIFIC PROJECT
    Route::get('activities/create/{project}', [ActivityController::class, 'create'])
        ->name('activities.create');

    // SAVE NEW ACTIVITY
    Route::post('activities/store', [ActivityController::class, 'store'])
        ->name('activities.store');

    // EDIT ACTIVITY ALLOCATIONS
    Route::get('activities/{id}/edit-allocations', [ActivityController::class, 'editAllocations'])
        ->name('activities.allocations.edit');

    // UPDATE ACTIVITY ALLOCATIONS
    Route::post('activities/{id}/update-allocations', [ActivityController::class, 'updateAllocations'])
        ->name('activities.allocations.update');

    // RESOURCE ROUTE FOR ACTIVITIES (EXCLUDING create + store to avoid conflicts)
    Route::resource('activities', ActivityController::class)->except(['create', 'store']);

    /*
    |--------------------------------------------------------------------------
    | SUB-ACTIVITIES
    |--------------------------------------------------------------------------
    */
    Route::resource('subactivities', SubActivityController::class);

    /*
    |--------------------------------------------------------------------------
    | PROJECT ALLOCATIONS CRUD
    |--------------------------------------------------------------------------
    */
    Route::resource('allocations', AllocationController::class);

    /*
    |--------------------------------------------------------------------------
    | REPORTS & ANALYTICS
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('/', [BudgetReportController::class, 'index'])->name('index');

        Route::get('/program/{id}', [BudgetReportController::class, 'programReport'])
            ->name('program');

        Route::get('/project/{id}', [BudgetReportController::class, 'projectReport'])
            ->name('project');

        Route::get('/activity/{id}', [BudgetReportController::class, 'activityReport'])
            ->name('activity');

        Route::get('/dashboard', [BudgetReportController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/export/pdf/{type}/{id}', [BudgetReportController::class, 'exportPDF'])
            ->name('export.pdf');

        Route::get('/export/excel/{type}/{id}', [BudgetReportController::class, 'exportExcel'])
            ->name('export.excel');
    });

    /*
|--------------------------------------------------------------------------
| BUDGET SUMMARY & EXECUTIVE REPORTS
|--------------------------------------------------------------------------
*/
Route::prefix('budget-summary')->group(function () {

    // Budget Dashboard Route
    Route::get('/dashboard',
        [AllocationSummaryController::class, 'dashboard']
    )->name('budgetsummary.dashboard');

    // Executive Reports Route
    Route::get('/executive',
        [AllocationSummaryController::class, 'executiveReports']
    )->name('budgetsummary.executive');
});





    /*
|--------------------------------------------------------------------------
| SUB-ACTIVITIES — FIXED ROUTES
|--------------------------------------------------------------------------
|
| Sub-Activity creation MUST reference its parent Activity.
| So we override create + store and then keep the resource
| for the rest of the CRUD.
|
*/

Route::get('subactivities/create/{activity}', [SubActivityController::class, 'create'])
    ->name('subactivities.create');

Route::post('subactivities/store', [SubActivityController::class, 'store'])
    ->name('subactivities.store');

// Edit allocations for sub-activity
Route::get('subactivities/{id}/edit-allocations', [SubActivityController::class, 'editAllocations'])
    ->name('subactivities.allocations.edit');

Route::post('subactivities/{id}/update-allocations', [SubActivityController::class, 'updateAllocations'])
    ->name('subactivities.allocations.update');

// Resource routes (excluding create & store)
Route::resource('subactivities', SubActivityController::class)->except(['create', 'store']);

});




/*
|--------------------------------------------------------------------------
| SITE VISIT EVALUATION ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/site-visit/teams', [SiteVisitEvaluationController::class, 'index'])->name('sitevisit.index');
Route::post('/site-visit/team/create', [SiteVisitEvaluationController::class, 'createTeam'])->name('sitevisit.create.team');
Route::post('/site-visit/team/{id}/add-member', [SiteVisitEvaluationController::class, 'addMember'])->name('sitevisit.add.member');
Route::post('/site-visit/team/{id}/assign', [SiteVisitEvaluationController::class, 'assignConsortium'])->name('sitevisit.assign.consortium');
Route::get('/site-visit/reports', [SiteVisitEvaluationController::class, 'report'])->name('sitevisit.report');

Route::get('/site-visit/dashboard', [SiteVisitEvaluationController::class, 'leaderDashboard'])->name('sitevisit.leader.dashboard');
Route::get('/site-visit/form/{consortium}', [SiteVisitEvaluationController::class, 'showForm'])->name('sitevisit.form');
Route::post('/site-visit/store', [SiteVisitEvaluationController::class, 'store'])->name('sitevisit.store');

Route::get('/site-visit/reports/pdf', [SiteVisitEvaluationController::class, 'exportAllPDF'])->name('sitevisit.report.pdf');
Route::get('/site-visit/reports/{id}/pdf', [SiteVisitEvaluationController::class, 'exportSinglePDF'])->name('sitevisit.report.single.pdf');

Route::get('/site-visit/member/{id}/remove', [SiteVisitEvaluationController::class, 'removeMember'])->name('sitevisit.remove.member');

Route::post('/sitevisit/{id}/request-rework', [SiteVisitEvaluationController::class, 'requestRework'])->name('sitevisit.request.rework');
Route::get('/sitevisit/{id}/edit-rework', [SiteVisitEvaluationController::class, 'editRework'])->name('sitevisit.edit.rework');
Route::post('/sitevisit/{id}/update-rework', [SiteVisitEvaluationController::class, 'updateRework'])->name('sitevisit.update.rework');



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact');
Route::get('/bids/{project}', [LandingPageController::class, 'showBid'])->name('landing.show');
Route::get('/callforproposal', [ApplicantController::class, 'create'])->name('applicants.create');
Route::get('/faq', [ApplicantController::class, 'faq'])->name('applicants.faq');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicants.store');
Route::get('/events', [ApplicantController::class, 'events'])->name('events');



/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change.form');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.change.update');
});



/*
|--------------------------------------------------------------------------
| GENERAL AUTH ROUTES (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Assignments
    Route::prefix('assignments')->group(function () {
        Route::get('/', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/store', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/{id}', [AssignmentController::class, 'show'])->name('assignments.show');
        Route::get('/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/{id}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    });

    // Evaluations
    Route::prefix('evaluations')->group(function () {
        Route::get('/analysis', [EvaluationController::class, 'analysis'])->name('evaluations.analysis');

        Route::get('/', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::get('/create/{applicant_id}', [EvaluationController::class, 'create'])->name('evaluations.create');

        Route::post('/store', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/{id}', [EvaluationController::class, 'show'])->name('evaluations.show');
        Route::get('/{id}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
        Route::put('/{id}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::delete('/{id}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');

        Route::get('/download/excel', [EvaluationController::class, 'downloadExcel'])->name('evaluations.download.excel');
        Route::get('/download/pdf', [EvaluationController::class, 'downloadPdf'])->name('evaluations.download.pdf');

        Route::post('/rework', [EvaluationController::class, 'sendRework'])->name('evaluations.rework');

        Route::get('/consolidated', [EvaluationController::class, 'consolidated'])->name('evaluations.consolidated');
        Route::get('/consolidated/pdf', [EvaluationController::class, 'consolidatedPdf'])->name('evaluations.consolidated.pdf');
    });

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Applicants
    Route::resource('applicants', ApplicantController::class)->except(['create']);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Bids
    Route::resource('bids', BidController::class);

    // Committees
    Route::resource('committees', CommitteeController::class);

    // Committee Members
    Route::resource('committee-members', CommitteeMemberController::class);

    // Users
    Route::resource('users', UserController::class);

    // Think Datasets
    Route::prefix('think-datasets')->group(function () {
        Route::get('/', [ThinkDatasetController::class, 'index'])->name('think-datasets.index');
        Route::get('/create', [ThinkDatasetController::class, 'create'])->name('think-datasets.create');
        Route::post('/', [ThinkDatasetController::class, 'store'])->name('think-datasets.store');
        Route::get('/{id}', [ThinkDatasetController::class, 'show'])->name('think-datasets.show');
        Route::get('/{id}/edit', [ThinkDatasetController::class, 'edit'])->name('think-datasets.edit');
        Route::put('/{id}', [ThinkDatasetController::class, 'update'])->name('think-datasets.update');
    });

    // Financial Assignments
    Route::prefix('financial')->group(function () {
        Route::get('/assign', [FinancialController::class, 'assign'])->name('financial.assign');
        Route::post('/assign/store', [FinancialController::class, 'storeAssignment'])->name('financial.assign.store');

        Route::get('/', [FinancialController::class, 'index'])->name('financial.index');
        Route::get('/create/{applicant_id}', [FinancialController::class, 'create'])->name('financial.create');
        Route::post('/', [FinancialController::class, 'store'])->name('financial.store');

        Route::get('/{id}', [FinancialController::class, 'show'])->name('financial.show');
        Route::get('/{id}/edit', [FinancialController::class, 'edit'])->name('financial.edit');
        Route::put('/{id}', [FinancialController::class, 'update'])->name('financial.update');
        Route::delete('/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');

        Route::delete('/assign/{id}', [FinancialController::class, 'deleteAssignment'])
            ->name('financial.assign.delete');
    });

    // Prescreening
    Route::prefix('prescreening')->group(function () {
        Route::get('/', [PrescreeningCriteriaController::class, 'index'])->name('prescreening.index');
        Route::get('/create', [PrescreeningCriteriaController::class, 'create'])->name('prescreening.create');
        Route::post('/', [PrescreeningCriteriaController::class, 'store'])->name('prescreening.store');

        Route::post('/email-eligible-yes', [PrescreeningCriteriaController::class, 'emailEligibleYes'])
            ->name('prescreening.emailEligibleYes');

        Route::get('/summary-report', [PrescreeningCriteriaController::class, 'downloadSummary'])
            ->name('prescreening.downloadSummary');

        Route::get('/{id}/report', [PrescreeningCriteriaController::class, 'downloadIndividual'])
            ->name('prescreening.downloadIndividual');

        Route::get('/{id}', [PrescreeningCriteriaController::class, 'show'])->name('prescreening.show');
        Route::get('/{id}/edit', [PrescreeningCriteriaController::class, 'edit'])->name('prescreening.edit');
        Route::put('/{id}', [PrescreeningCriteriaController::class, 'update'])->name('prescreening.update');
        Route::delete('/{id}', [PrescreeningCriteriaController::class, 'destroy'])->name('prescreening.destroy');
    });
});

require __DIR__ . '/auth.php';
