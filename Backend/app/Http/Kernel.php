<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    // ...existing code...

    protected $routeMiddleware = [
        // other middlewares
        'allowedRoles' => \App\Http\Middleware\AllowedRolesMiddleware::class,  // Register the middleware
        'role' => \App\Http\Middleware\RoleMiddleware::class,  // Register the RoleMiddleware

        // For API routes
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    // ...existing code...
}
