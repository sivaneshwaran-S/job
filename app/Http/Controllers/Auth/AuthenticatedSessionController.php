<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

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

    $user = User::where('email', $request->email)->first();

    // ❌ User not found OR wrong password
    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // ✅ ADMIN LOGIN → SKIP ALL CHECKS
    if ($user->role === 'admin') {
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    // ❌ If not admin → must verify email first
    if (!$user->hasVerifiedEmail()) {
        return back()->with('error', 'Please verify your email before logging in.');
    }

    // ❌ Only employees/employers need admin approval
    if (in_array($user->role, ['employer', 'employee'])) {

        if ($user->status === 'pending') {
            return back()->with('error', '⚠️ Your account is pending admin approval.');
        }

        if ($user->status === 'rejected') {
            return back()->with('error', '❌ Your registration has been rejected.');
        }
    }

    // ✅ If all checks passed → login success
    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

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
