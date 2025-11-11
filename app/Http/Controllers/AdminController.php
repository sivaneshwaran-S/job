<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\Employer;

class AdminController extends Controller
{
    public function dashboard()
    {
        $employers = User::where('role', 'employer')->count();
        $employees = User::where('role', 'employee')->count();
        $jobs = \App\Models\JobListing::count();

        return view('admin.dashboard', compact('employers', 'employees', 'jobs'));
    }

    // 🟡 1️⃣ Show Pending Employers
    public function pendingEmployers()
    {
        $employers = Employer::where('verified', 0)->get();
        return view('admin.employers.pending', compact('employers'));
    }

    // 🟢 2️⃣ Show Approved Employers
    public function approvedEmployers()
    {
        $employers = Employer::where('verified', 1)->get();
        return view('admin.employers.approved', compact('employers'));
    }

    // 🔴 3️⃣ Show Rejected Employers
    public function rejectedEmployers()
    {
        $employers = Employer::where('verified', 2)->get();
        return view('admin.employers.rejected', compact('employers'));
    }

    // ✅ 4️⃣ Approve Employer
    public function approveEmployer($id)
    {
        $employer = Employer::findOrFail($id);
        $employer->update(['verified' => 1]);

        return redirect()->route('admin.employers.pending')->with('success', 'Employer approved successfully!');
    }

    // ❌ 5️⃣ Reject Employer
    public function rejectEmployer($id)
    {
        $employer = Employer::findOrFail($id);
        $employer->update(['verified' => 2]);

        return redirect()->route('admin.employers.pending')->with('error', 'Employer rejected.');
    }
    public function employees()
{
    $employees = \App\Models\User::where('role', 'employee')->get();
    return view('admin.employees.index', compact('employees'));
}
public function allJobs()
{
    $jobs = \App\Models\JobListing::with('employer')->latest()->get();
    return view('admin.jobs.all', compact('jobs'));
}
public function viewApplicants($id)
{
    $job = \App\Models\JobListing::with([
        'employer.user',
        'applications.employee.user'
    ])->findOrFail($id);

    return view('admin.jobs.applicants', compact('job'));
}




}
