<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Employee;

class JobBrowseController extends Controller
{
    public function index()
    {
        // show jobs (remove is_approved if you don't have that column)
        $jobs = JobListing::latest()->get();
        return view('employee.jobs.index', compact('jobs'));
    }
    

    // show the apply form
    public function showApplyForm($id)
    {
        $job = JobListing::findOrFail($id);

        // ensure user has an employee profile
        $employee = Employee::where('user_id', Auth::id())->first();
        if (!$employee) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your profile before applying.');
        }

        // optionally block if already applied
        $already = JobApplication::where('job_id', $id)->where('employee_id', $employee->id)->exists();
        if ($already) {
            return redirect()->route('employee.jobs.index')->with('warning', 'You already applied for this job.');
        }

        return view('employee.jobs.apply', compact('job'));
    }

    // handle the form submit
   public function apply(Request $request, $id)
{
    $request->validate([
        'cover_letter' => 'required|string|max:2000',
        'skills' => 'nullable|string|max:500',
        'education' => 'nullable|string|max:255',
    ]);

    $employee = Employee::where('user_id', Auth::id())->firstOrFail();

    // Prevent applying without resume
    if (!$employee->resume_file) {
        return redirect()
            ->route('employee.profile.edit')
            ->with('error', 'Please upload your resume before applying for a job.');
    }

    // Check already applied
    $exists = JobApplication::where('job_id', $id)
                ->where('employee_id', $employee->id)
                ->exists();

    if ($exists) {
        return redirect()->route('employee.jobs.index')
            ->with('warning', 'You already applied for this job.');
    }

    JobApplication::create([
        'job_id' => $id,
        'employee_id' => $employee->id,
        'cover_letter' => $request->cover_letter,
        'status' => 'pending',
    ]);

    return redirect()->route('employee.jobs.index')
        ->with('success', 'Application submitted successfully.');
}
}
