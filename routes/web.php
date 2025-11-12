<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\Employer\JobController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// 🧩 COMMON DASHBOARD (default Laravel)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🧑‍💼 EMPLOYER ROUTES
Route::middleware(['auth', 'role:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard');
        Route::resource('jobs', JobController::class);
    });

// 🧩 ADMIN ROUTES
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // 👥 User Management
        Route::get('/users/manage', [AdminController::class, 'manageUsers'])->name('users.manage');
        Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        // 💼 Job Management
        Route::get('/jobs', [AdminController::class, 'allJobs'])->name('jobs.all');
        Route::get('/jobs/{id}/applicants', [AdminController::class, 'viewApplicants'])->name('jobs.applicants');
        Route::post('/applicants/{id}/approve', [AdminController::class, 'approveApplicant'])->name('applicants.approve');
    });

// 🕓 Registration pending page
Route::get('/registration/pending', fn() => view('auth.registration-pending'))
    ->name('registration.pending');

// 🧍 PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
