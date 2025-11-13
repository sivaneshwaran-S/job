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

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 🚫 Block pending or rejected users
    if (in_array($user->role, ['employer', 'employee'])) {
        if ($user->status === 'pending') {
            return back()->with('error', '⚠️ Your account is pending admin approval.');
        }

        if ($user->status === 'rejected') {
            return back()->with('error', '❌ Your registration has been rejected.');
        }
    }

    // ✅ Passed all checks — proceed with login
    \Illuminate\Support\Facades\Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    // 🎯 Redirect to the unified dashboard
    return redirect()->route('dashboard');
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
