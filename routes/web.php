<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\ApplicantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Employee\JobBrowseController;

// 🏠 Landing page
Route::get('/', fn() => view('welcome'));

// 🔹 Single Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔹 Employer Routes (no role middleware)
Route::prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard');
        Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
        Route::post('/applicants/{id}/approve', [AdminController::class, 'approveApplicant'])->name('admin.applicants.approve');
Route::post('/applicants/{id}/reject', [AdminController::class, 'rejectApplicant'])->name('admin.applicants.reject');

         Route::get('/profile', [\App\Http\Controllers\Employer\EmployerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Employer\EmployerProfileController::class, 'update'])->name('profile.update');

        // ✅ This single line handles all job routes (index, create, store, edit, update, destroy)
        Route::resource('jobs', JobController::class);
    });


// 🔹 Admin Routes (no is_admin middleware)
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // 👥 Manage Users
        Route::get('/users/manage', [AdminController::class, 'manageUsers'])->name('users.manage');
        Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        // 💼 Manage Jobs
        Route::get('/jobs/all', [AdminController::class, 'allJobs'])->name('jobs.all');
        Route::get('/jobs/{id}/applicants', [AdminController::class, 'viewApplicants'])->name('jobs.applicants');

        // 🟢 Approve Applicant
        Route::post('/applicants/{id}/approve', [AdminController::class, 'approveApplicant'])->name('applicants.approve');
    });

    Route::prefix('employee')
    ->name('employee.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/jobs', [JobBrowseController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{id}/apply', [JobBrowseController::class, 'showApplyForm'])->name('jobs.showApplyForm');
        Route::post('/jobs/{id}/apply', [JobBrowseController::class, 'apply'])->name('jobs.apply');
    
        Route::get('/profile', [EmployeeProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
    });
// 🔹 Registration Pending
Route::get('/registration/pending', fn() => view('auth.registration-pending'))
    ->name('registration.pending');

// 🔹 Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
