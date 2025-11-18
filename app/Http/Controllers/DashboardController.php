<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Employer;
use App\Models\Employee;
use App\Models\Job;
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

            'latestJobs' => [],
            'latestEmployers' => [],
            'latestEmployees' => [],
            'jobStats' => [],

            // Employer chart data
            'applicationsPerJob' => [],
            'dailyApplications' => [],
            'jobStatusCount' => [],

            // Employee chart data
            'employeeDailyApplications' => [],
            'applicationStatus' => [],
        ];

        // -----------------------------
        //      ADMIN SECTION
        // -----------------------------
        if ($user->role === 'admin') {

            $data['employers'] = Employer::count();
            $data['employees'] = Employee::count();
            $data['jobs'] = Job::count();

            $data['latestJobs'] = Job::latest()->limit(5)->get();
            $data['latestEmployers'] = Employer::latest()->limit(5)->get();
            $data['latestEmployees'] = Employee::latest()->limit(5)->get();

            // Jobs posted in last 7 days
            $data['jobStats'] = Job::whereDate('created_at', '>=', now()->subDays(7))
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

    if (!$employer) {
        // Prevent errors
        return view('dashboard', [
            'user' => $user,
            'data' => $data
        ]);
    }

    // Total jobs posted
    $data['jobs'] = Job::where('employer_id', $employer->id)->count();

    // Latest 5 jobs
    $data['latestJobs'] = Job::where('employer_id', $employer->id)
        ->latest()
        ->limit(5)
        ->get();

    // Jobs posted per day (last 7 days)
    $data['jobStats'] = Job::where('employer_id', $employer->id)
        ->whereDate('created_at', '>=', now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total', 'date');

    // Applications received per job
    $data['applicationsPerJob'] = Job::where('employer_id', $employer->id)
        ->withCount('applications')
        ->get(['title', 'applications_count']);

    // Daily applications received
    $data['dailyApplications'] = JobApplication::whereHas('jobListing', function ($q) use ($employer) {
        $q->where('employer_id', $employer->id);
    })
        ->whereDate('created_at', '>=', now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total', 'date');

    // Job status count
    $data['jobStatusCount'] = Job::where('employer_id', $employer->id)
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');
}


        // -----------------------------
        //      EMPLOYEE SECTION
        // -----------------------------
        elseif ($user->role === 'employee') {

            $employee = Employee::where('user_id', $user->id)->first();

            $data['appliedJobs'] = JobApplication::where('employee_id', $employee->id)->count();

            // Applications per day (last 7 days)
            $data['employeeDailyApplications'] = JobApplication::where('employee_id', $employee->id)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');

            // Count by status (applied, shortlisted, rejected, hired)
            $data['applicationStatus'] = JobApplication::where('employee_id', $employee->id)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
        }

        return view('dashboard', compact('user', 'data'));
    }
}
