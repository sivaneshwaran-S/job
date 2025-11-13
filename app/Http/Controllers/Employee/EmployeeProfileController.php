<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function edit()
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        if (!$employee) {
            // If employee record doesn’t exist, create one automatically
            $employee = Employee::create([
                'user_id' => Auth::id(),
            ]);
        }

        return view('employee.profile.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'qualification' => 'nullable|string|max:255',
            'experience_years' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:500',
            'preferred_location' => 'nullable|string|max:255',
            'resume_file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        // Handle resume upload
        if ($request->hasFile('resume_file')) {
            $resumePath = $request->file('resume_file')->store('resumes', 'public');
            $employee->resume_file = $resumePath;
        }

        $employee->update($request->except('resume_file'));
        $employee->save();

        return redirect()->route('employee.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
