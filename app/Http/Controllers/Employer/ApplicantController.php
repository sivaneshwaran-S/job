<?php 


namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\JobApplication;

class ApplicantController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();

        $jobs = JobListing::where('employer_id', $employerId)->pluck('id');

        $applications = JobApplication::with(['job', 'employee'])
            ->whereIn('job_id', $jobs)
            ->latest()
            ->get();

        return view('employer.applicants.index', compact('applications'));
    }
}
