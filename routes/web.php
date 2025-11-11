<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('/employer/dashboard', function () {
    return view('employer.dashboard');
})->name('employer.dashboard');

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->name('employee.dashboard');


Route::get('/admin/jobs/{id}/applicants', [AdminController::class, 'viewApplicants'])
    ->name('admin.jobs.applicants');

Route::get('/registration/pending', function () {
    return view('auth.registration-pending');
})->name('registration.pending');


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Employer management
    Route::get('/admin/employers/pending', [AdminController::class, 'pendingEmployers'])->name('admin.employers.pending');
    Route::get('/admin/employers/approved', [AdminController::class, 'approvedEmployers'])->name('admin.employers.approved');
    Route::get('/admin/employers/rejected', [AdminController::class, 'rejectedEmployers'])->name('admin.employers.rejected');
    Route::post('/admin/employers/{id}/approve', [AdminController::class, 'approveEmployer'])->name('admin.employers.approve');
    Route::post('/admin/employers/{id}/reject', [AdminController::class, 'rejectEmployer'])->name('admin.employers.reject');

    // ✅ Employee management
    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees.index');
    Route::get('/admin/employees/pending', [AdminController::class, 'pendingEmployees'])->name('admin.employees.pending');
    Route::post('/admin/employees/{id}/approve', [AdminController::class, 'approveEmployee'])->name('admin.employees.approve');
    Route::post('/admin/employees/{id}/reject', [AdminController::class, 'rejectEmployee'])->name('admin.employees.reject');
});


Route::get('/admin/jobs', [AdminController::class, 'allJobs'])->name('admin.jobs.all');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
