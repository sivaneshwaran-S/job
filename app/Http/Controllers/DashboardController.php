<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employer;
use App\Models\Employee;
use App\Models\JobListing;
use App\Models\Application;

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
        ];

        if ($user->role === 'admin') {
            $data['employers'] = Employer::count();
            $data['employees'] = Employee::count();
            $data['jobs'] = JobListing::count();
        } 
        elseif ($user->role === 'employer') {
            $employer = Employer::where('user_id', $user->id)->first();
            $data['jobs'] = $employer ? JobListing::where('employer_id', $employer->id)->count() : 0;
        } 
        elseif ($user->role === 'employee') {
            $employee = Employee::where('user_id', $user->id)->first();
            $data['applications'] = $employee ? Application::where('employee_id', $employee->id)->count() : 0;
        }

        return view('dashboard', compact('user', 'data'));
    }
}
