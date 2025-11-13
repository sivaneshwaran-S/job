<?php
namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;

class EmployerProfileController extends Controller
{
    public function edit()
    {
        $employer = Employer::where('user_id', Auth::id())->first();
        return view('employer.profile.edit', compact('employer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:150',
            'industry_type' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'gst_number' => 'nullable|string|max:50',
        ]);

        $employer = Employer::where('user_id', Auth::id())->first();
        $employer->update($request->only([
            'company_name',
            'industry_type',
            'address',
            'website',
            'gst_number',
        ]));

        return back()->with('success', 'Company profile updated successfully!');
    }
}
