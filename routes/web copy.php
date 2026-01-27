<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'show'])->name('password.change.form');
    Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'update'])->name('password.change.update');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');




Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\LandingPageController;

// Public Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
// Public Application Form
Route::get('/apply', [LandingPageController::class, 'create'])->name('applicants.create');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicants.store');
// View a single bid
Route::get('/bids/{project}', [LandingPageController::class, 'showBid'])->name('landing.show');



Route::middleware(['auth'])->group(function () {

    // 🟩 Category Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // 🟦 Project Routes
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    // 🟨 Bid Routes
    Route::prefix('bids')->name('bids.')->group(function () {
        Route::get('/', [BidController::class, 'index'])->name('index');
        Route::get('/create', [BidController::class, 'create'])->name('create');
        Route::post('/', [BidController::class, 'store'])->name('store');
        Route::get('/{bid}', [BidController::class, 'show'])->name('show');
        Route::get('/{bid}/edit', [BidController::class, 'edit'])->name('edit');
        Route::put('/{bid}', [BidController::class, 'update'])->name('update');
        Route::delete('/{bid}', [BidController::class, 'destroy'])->name('destroy');
    });

    // 🟧 Committee Routes
    Route::prefix('committees')->name('committees.')->group(function () {
        Route::get('/', [CommitteeController::class, 'index'])->name('index');
        Route::get('/create', [CommitteeController::class, 'create'])->name('create');
        Route::post('/', [CommitteeController::class, 'store'])->name('store');
        Route::get('/{committee}', [CommitteeController::class, 'show'])->name('show');
        Route::get('/{committee}/edit', [CommitteeController::class, 'edit'])->name('edit');
        Route::put('/{committee}', [CommitteeController::class, 'update'])->name('update');
        Route::delete('/{committee}', [CommitteeController::class, 'destroy'])->name('destroy');
    });

   // 🟫 Committee Member Routes
    Route::prefix('committee-members')->name('committee-members.')->group(function () {
        Route::get('/', [CommitteeMemberController::class, 'index'])->name('index');
        Route::get('/create', [CommitteeMemberController::class, 'create'])->name('create');
        Route::post('/', [CommitteeMemberController::class, 'store'])->name('store');
        Route::get('/{committeeMember}', [CommitteeMemberController::class, 'show'])->name('show'); // ✅ Corrected path
        Route::delete('/{committeeMember}', [CommitteeMemberController::class, 'destroy'])->name('destroy');
    });



    // 🟪 Evaluation Routes
        Route::prefix('evaluations')->name('evaluations.')->group(function () {
            Route::get('/', [EvaluationController::class, 'index'])->name('index');
            Route::get('/create', [EvaluationController::class, 'create'])->name('create');
            Route::post('/', [EvaluationController::class, 'store'])->name('store');
            Route::get('/{evaluation}', [EvaluationController::class, 'show'])->name('show');
            Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('edit');
            Route::put('/{evaluation}', [EvaluationController::class, 'update'])->name('update');
            Route::delete('/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy');
        });

    });



    Route::middleware(['auth'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });


use App\Http\Controllers\ApplicantController;

// Public form (no auth)
Route::get('/apply', [ApplicantController::class, 'create'])->name('applicants.create');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicants.store');




Route::middleware(['auth'])->group(function () {
    Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
    Route::get('/applicants/{id}', [ApplicantController::class, 'show'])->name('applicants.show');
    Route::delete('/applicants/{id}', [ApplicantController::class, 'destroy'])->name('applicants.destroy');
});

// Authenticated admin panel
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [\App\Http\Controllers\ChangePasswordController::class, 'show'])->name('password.change.form');
    Route::post('/change-password', [\App\Http\Controllers\ChangePasswordController::class, 'update'])->name('password.change.update');
});






require __DIR__.'/auth.php';
