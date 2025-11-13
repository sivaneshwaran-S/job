<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\JobApplication;

class EmployerController extends Controller
{
    // 🏠 Employer Dashboard
    public function index()
    {
        $employerId = Auth::id();

        $totalJobs = JobListing::where('employer_id', $employerId)->count();
        $pendingJobs = JobListing::where('employer_id', $employerId)
            ->where('status', 'pending')
            ->count();

        $totalApplicants = JobApplication::whereHas('job', function ($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        })->count();

        $jobs = JobListing::withCount('applications')
            ->where('employer_id', $employerId)
            ->latest()
            ->take(5)
            ->get();

        return view('employer.dashboard', compact(
            'totalJobs',
            'pendingJobs',
            'totalApplicants',
            'jobs'
        ));
    }
}
