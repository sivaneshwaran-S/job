<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\JobApplication;

class ApplicantController extends Controller
{
    public function index()
    {
        // Get logged-in employer based on user_id
        $employer = Employer::where('user_id', auth()->id())->firstOrFail();

        // Fetch all approved applications for jobs by this employer
        $applications = JobApplication::whereHas('job', function($query) use ($employer) {
                $query->where('employer_id', $employer->id);
            })
            ->where('status', 'approved')
            ->with(['job', 'employee.user'])
            ->latest()
            ->get();

        return view('employer.applicants.index', compact('applications'));
    }
}
