<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;

class JobController extends Controller
{
    public function index()
    {
        $employer = auth()->user()->employer;
        $jobs = JobListing::where('employer_id', $employer->id)->latest()->get();

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
        ]);

        JobListing::create([
            'employer_id' => auth()->user()->employer->id,
            'title' => $request->title,
            'description' => $request->description,
            'qualification_required' => $request->qualification_required,
            'experience_required' => $request->experience_required ?? 0,
            'skills_required' => $request->skills_required,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'status' => 'open',
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    // ✏️ EDIT JOB
    public function edit($id)
    {
        $job = JobListing::findOrFail($id);

        // Ensure only owner can edit
        if ($job->employer->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('employer.jobs.edit', compact('job'));
    }

    // 🔄 UPDATE JOB
    public function update(Request $request, $id)
    {
        $job = JobListing::findOrFail($id);

        if ($job->employer->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,internship,contract',
        ]);

        $job->update($request->all());

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    // 🗑 DELETE JOB
    public function destroy($id)
    {
        $job = JobListing::findOrFail($id);

        if ($job->employer->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully.');
    }
}
