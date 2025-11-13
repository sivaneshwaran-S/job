<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        // 🧱 Handles maintenance mode, trusted proxies, etc.
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // 🧭 Session + CSRF + Cookies
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // ⚙️ Throttle + Bindings for API routes
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    // ... inside class Kernel extends HttpKernel

protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ... other middleware ...
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

    // add this:
    'role' => \App\Http\Middleware\RoleMiddleware::class,

    // if you have an is_admin middleware you can keep it:
    'is_admin' => \App\Http\Middleware\IsAdmin::class,
];

}
