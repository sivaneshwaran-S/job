<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employer;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 👇 Add this Fortify authentication logic
        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                
                // 🟡 If user is an employer, check verification status
                if ($user->role === 'employer') {
                    $employer = Employer::where('user_id', $user->id)->first();

                    if ($employer && $employer->verified == 0) {
                        session()->flash('error', 'Your account is pending admin approval.');
                        return null; // ❌ stop login
                    }

                    if ($employer && $employer->verified == 2) {
                        session()->flash('error', 'Your registration has been rejected.');
                        return null; // ❌ stop login
                    }
                }

                // ✅ Login success
                return $user;
            }

            return null; // ❌ invalid credentials
        });
    }
}
