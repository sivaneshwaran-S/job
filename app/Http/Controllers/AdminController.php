<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Count users by role
        $employers = User::where('role', 'employer')->count();
        $employees = User::where('role', 'employee')->count();

        // Count jobs (optional: only approved jobs, if you have a column)
        $jobs = Job::count();

        return view('admin.dashboard', compact('employers', 'employees', 'jobs'));
    }
}
