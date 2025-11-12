<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\JobApplication;

class EmployerController extends Controller
{
    /**
     * 🏠 Employer Dashboard
     */
    public function dashboard()
    {
        $employerId = Auth::id();

        $totalJobs = JobListing::where('employer_id', $employerId)->count();

        $pendingJobs = JobListing::where('employer_id', $employerId)
            ->where('status', 'open')
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

    /**
     * 💼 Show all jobs posted by employer
     */
    public function jobs()
    {
        $jobs = JobListing::where('employer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    /**
     * ➕ Show job creation form
     */
    public function createJob()
    {
        return view('employer.jobs.create');
    }

    /**
     * 💾 Store a new job
     */
    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'qualification_required' => 'required|string|max:150',
            'experience_required' => 'required|integer|min:0',
            'skills_required' => 'required|string',
            'location' => 'required|string|max:100',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
        ]);

        JobListing::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'qualification_required' => $request->qualification_required,
            'experience_required' => $request->experience_required,
            'skills_required' => $request->skills_required,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'status' => 'open',
            'is_approved' => false, // admin approval pending
        ]);

        return redirect()->route('employer.dashboard')->with('success', 'Job posted successfully and awaiting admin approval.');
    }
}
