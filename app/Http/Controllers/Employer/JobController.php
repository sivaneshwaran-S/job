<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // 🧭 List all jobs by this employer
    public function index()
    {
        $employer = auth()->user()->employer;

        $jobs = JobListing::where('employer_id', $employer->id)
            ->latest()
            ->get();

        return view('employer.jobs.index', compact('jobs'));
    }

    // 📝 Show create form
    public function create()
    {
        return view('employer.jobs.create');
    }

    // 💾 Store a new job
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'qualification_required' => 'nullable|string|max:150',
            'experience_required' => 'nullable|integer|min:0',
            'skills_required' => 'nullable|string',
            'location' => 'nullable|string|max:100',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
            'status' => 'required|in:open,closed',
        ]);

        $employer = auth()->user()->employer;

        JobListing::create([
            ...$request->all(),
            'employer_id' => $employer->id,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    // ✏️ Show edit form
    public function edit($id)
    {
        $employer = auth()->user()->employer;
        $job = JobListing::where('id', $id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        return view('employer.jobs.edit', compact('job'));
    }

    // 🔁 Update job
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'qualification_required' => 'nullable|string|max:150',
            'experience_required' => 'nullable|integer|min:0',
            'skills_required' => 'nullable|string',
            'location' => 'nullable|string|max:100',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
            'status' => 'required|in:open,closed',
        ]);

        $employer = auth()->user()->employer;
        $job = JobListing::where('id', $id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        $job->update($request->all());

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    // ❌ Delete job
    public function destroy($id)
    {
        $employer = auth()->user()->employer;
        $job = JobListing::where('id', $id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

    // 👥 View applicants for a job
    public function applicants($id)
    {
        $employer = auth()->user()->employer;
        $job = JobListing::where('id', $id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        // Assuming you have an Application model with job_id + employee_id
        $applicants = Application::where('job_id', $job->id)
            ->with('employee.user')
            ->get();

        return view('employer.jobs.applicants', compact('job', 'applicants'));
    }
}
