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

        // Get jobs posted by this employer
        $jobs = JobListing::where('employer_id', $employerId)->pluck('id');

        // Fetch applications with related employee and user data
        $applications = JobApplication::with(['job', 'employee.user'])
            ->whereIn('job_id', $jobs)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('employer.applicants.index', compact('applications'));
    }
}
