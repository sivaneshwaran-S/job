<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:employee,employer'],
        'phone' => ['nullable', 'string', 'max:15'],
        'location' => ['nullable', 'string', 'max:100'],
        'company_name' => ['nullable', 'string', 'max:150'],
    ]);

    // 1️⃣ Create user first
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'phone' => $request->phone,
        'location' => $request->location,
        'status' => 1,
    ]);

    // 2️⃣ Create related record
    if ($request->role === 'employer') {
        \App\Models\Employer::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name ?? 'Unnamed Company',
            'industry_type' => null,
            'address' => null,
            'website' => null,
            'gst_number' => null,
            'verified' => 0,
        ]);
    } elseif ($request->role === 'employee') {
        \App\Models\Employee::create([
            'user_id' => $user->id,
            'gender' => null,
            'dob' => null,
            'qualification' => null,
            'experience_years' => 0,
            'skills' => null,
            'resume_file' => null,
            'preferred_location' => null,
        ]);
    }

    // 3️⃣ Trigger events + login
    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('dashboard');
}
}
