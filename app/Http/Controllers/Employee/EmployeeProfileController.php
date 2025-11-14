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

        // ⭐ ONLY PDF allowed
        'resume_file' => 'nullable|mimes:pdf|max:2048',
    ]);

    $employee = Employee::where('user_id', Auth::id())->firstOrFail();

    // Fill all basic fields
    $employee->fill($request->except('resume_file'));

    // ⭐ Upload resume with auto-renamed filename
    if ($request->hasFile('resume_file')) {

        // Delete old file
        if ($employee->resume_file && file_exists(storage_path("app/public/{$employee->resume_file}"))) {
            unlink(storage_path("app/public/{$employee->resume_file}"));
        }

        // Auto rename: resume_userID_timestamp.pdf
        $newName = 'resume_' . Auth::id() . '_' . time() . '.' . $request->resume_file->extension();

        $path = $request->resume_file->storeAs('resumes', $newName, 'public');
        $employee->resume_file = $path;
    }

    $employee->save();

    return back()->with('success', 'Profile updated successfully!');
}

public function deleteResume()
{
    $employee = Employee::where('user_id', Auth::id())->firstOrFail();

    if ($employee->resume_file && file_exists(storage_path("app/public/{$employee->resume_file}"))) {
        unlink(storage_path("app/public/{$employee->resume_file}"));
    }

    $employee->resume_file = null;
    $employee->save();

    return back()->with('success', 'Resume deleted successfully.');
}

}
