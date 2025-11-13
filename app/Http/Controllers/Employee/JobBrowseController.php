<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Employee;
use Illuminate\Http\Request;

class JobBrowseController extends Controller
{
    // 🧭 Show available jobs
    public function index()
    {
        // Only show approved jobs
        $jobs = JobListing::latest()
            ->get();

        return view('employee.jobs.index', compact('jobs'));
    }

    // 📝 Apply for a job
    public function apply($id)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        if (!$employee) {
            return back()->with('error', 'You must complete your employee profile before applying.');
        }

        // Check if already applied
        $alreadyApplied = JobApplication::where('job_id', $id)
            ->where('employee_id', $employee->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('warning', 'You have already applied for this job.');
        }

        // Create new application
        JobApplication::create([
            'job_id' => $id,
            'employee_id' => $employee->id,
            'cover_letter' => 'N/A',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your application has been submitted successfully.');
    }
}
