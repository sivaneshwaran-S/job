<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

public function store(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // ✅ Get user by email
    $user = \App\Models\User::where('email', $request->email)->first();

    // ❌ If no user or wrong password
    if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 🟡 Check employer approval status
    if ($user->role === 'employer') {
        $employer = \App\Models\Employer::where('user_id', $user->id)->first();

        if ($employer && $employer->verified == 0) {
            return back()->with('error', '⚠️ Your account is pending admin approval.');
        }

        if ($employer && $employer->verified == 2) {
            return back()->with('error', '❌ Your registration has been rejected.');
        }
    }

    // ✅ Passed checks, proceed with login
    \Illuminate\Support\Facades\Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'employer') {
        return redirect()->route('employer.dashboard');
    } else {
        return redirect()->route('employee.dashboard');
    }
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
