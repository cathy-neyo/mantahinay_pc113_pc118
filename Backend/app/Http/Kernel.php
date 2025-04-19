<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ...existing code...

    protected $middlewareGroups = [
        'web' => [
            // ...existing code...
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            'role' => \App\Http\Middleware\RoleMiddleware::class,

        ],
    ];

    // ...existing code...
}
?>