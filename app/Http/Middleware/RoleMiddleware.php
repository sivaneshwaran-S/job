<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect based on user type or show 403
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
