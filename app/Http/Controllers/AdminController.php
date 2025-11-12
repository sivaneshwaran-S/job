<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\JobApplication;

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
    public function approveApplicant($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        $application->update(['status' => 'approved']);

        return back()->with('success', 'Applicant approved successfully!');
    }
}
