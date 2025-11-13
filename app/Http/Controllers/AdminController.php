<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Employee;

class AdminController extends Controller
{
    // 🏠 Dashboard
   public function dashboard()
{
    $totalEmployers = User::where('role', 'employer')
        ->where('status', 'approved')
        ->count();

    $totalEmployees = User::where('role', 'employee')
        ->where('status', 'approved')
        ->count();

    $totalJobs = JobListing::count();

    return view('admin.dashboard', [
        'employers' => $totalEmployers,
        'employees' => $totalEmployees,
        'jobs' => $totalJobs,
    ]);
}

public function manageUsers(Request $request)
{
    $status = $request->input('status');
    $query = User::whereIn('role', ['employer', 'employee']);

    if ($status) {
        $query->where('status', $status);
    }

    $users = $query->latest()->get();

    return view('admin.users.manage', compact('users', 'status'));
}

  // ✅ Approve User
public function approveUser($id)
{
    $user = User::findOrFail($id);
    $user->update(['status' => 'approved']);

    return back()->with('success', "{$user->name} has been approved!");
}

// ❌ Reject User
public function rejectUser($id)
{
    $user = User::findOrFail($id);
    $user->update(['status' => 'rejected']);

    return back()->with('error', "{$user->name} has been rejected.");
}

    // 💼 All Jobs
    public function allJobs()
    {
        $jobs = JobListing::with('employer')->latest()->get();
        return view('admin.jobs.all', compact('jobs'));
    }

    // 👀 View Job Applicants
    public function viewApplicants($id)
    {
        $job = JobListing::with(['employer.user', 'applications.employee.user'])->findOrFail($id);
        return view('admin.jobs.applicants', compact('job'));
    }

    // 🟢 Approve Applicant


public function approveApplicant($id)
{
    // Find the job application by its ID
    $application = JobApplication::find($id);

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // employee_id in job_applications corresponds to user_id in employees
    $employee = Employee::where('user_id', $application->employee_id)->first();

    if (!$employee) {
        return redirect()->back()->with('error', 'Employee not found for user_id: '.$application->employee_id);
    }

    // ✅ Update status in employees table
    $employee->status = 'approved';
    $employee->save();

    // Optional: if you want to update the job_applications table too
    $application->status = 'approved';
    $application->save();

    return redirect()->back()->with('success', 'Employee approved successfully!');
}

}
