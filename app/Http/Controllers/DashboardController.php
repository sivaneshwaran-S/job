<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Employer;
use App\Models\Employee;
use App\Models\JobListing;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'employers' => 0,
            'employees' => 0,
            'jobs' => 0,
            'applications' => 0,

            // New sections (default empty)
            'latestJobs' => [],
            'latestEmployers' => [],
            'latestEmployees' => [],
            'jobStats' => [],
        ];

        // -----------------------------
        //      ADMIN SECTION
        // -----------------------------
        if ($user->role === 'admin') {

            $data['employers'] = Employer::count();
            $data['employees'] = Employee::count();
            $data['jobs'] = JobListing::count();

            

            // Fetch last 5 recent entries
            $data['latestJobs'] = JobListing::latest()->limit(5)->get();
            $data['latestEmployers'] = Employer::latest()->limit(5)->get();
            $data['latestEmployees'] = Employee::latest()->limit(5)->get();

            // Fetch job posting stats for last 7 days
            $data['jobStats'] = JobListing::whereDate('created_at', '>=', now()->subDays(7))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');
        }

        // -----------------------------
        //      EMPLOYER SECTION
        // -----------------------------
        elseif ($user->role === 'employer') {
            $employer = Employer::where('user_id', $user->id)->first();
            $data['jobs'] = $employer
                ? JobListing::where('employer_id', $employer->id)->count()
                : 0;
        }

        // -----------------------------
        //      EMPLOYEE SECTION
        // -----------------------------
        elseif ($user->role === 'employee') {
            $employee = Employee::where('user_id', $user->id)->first();
            $data['appliedJobs'] = $employee
                ? JobApplication::where('employee_id', $employee->id)->count()
                : 0;
        }

        return view('dashboard', compact('user', 'data'));
    }
}
