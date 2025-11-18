<?php
use Illuminate\Http\Request;             
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\ApplicantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Employee\JobBrowseController;


Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    // Validate signed URL manually
    if (! URL::hasValidSignature($request)) {
        abort(403, 'Invalid or expired verification link.');
    }

    // Login the user without session conflict
    Auth::loginUsingId($id);

    // Mark email as verified
    $request->user()->markEmailAsVerified();

    Auth::logout(); // logout so they can login cleanly

    return redirect('/login')->with('success', 'Email verified successfully. Please login now.');

})->name('verification.verify');

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard');
        Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
        Route::post('/applicants/{id}/approve', [AdminController::class, 'approveApplicant'])->name('admin.applicants.approve');
        Route::post('/applicants/{id}/reject', [AdminController::class, 'rejectApplicant'])->name('admin.applicants.reject');

        Route::get('/profile', [\App\Http\Controllers\Employer\EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Employer\EmployerProfileController::class, 'update'])->name('profile.update');


        Route::resource('jobs', JobController::class);
    });


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/users/manage', [AdminController::class, 'manageUsers'])->name('users.manage');
        Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        Route::get('/jobs/all', [AdminController::class, 'allJobs'])->name('jobs.all');
        Route::get('/jobs/{id}/applicants', [AdminController::class, 'viewApplicants'])->name('jobs.applicants');

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


Route::get('/registration/pending', fn() => view('auth.registration-pending'))
    ->name('registration.pending');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/employee/resume/delete', [EmployeeProfileController::class, 'deleteResume'])
    ->name('employee.resume.delete')
    ->middleware('auth');


require __DIR__ . '/auth.php';
