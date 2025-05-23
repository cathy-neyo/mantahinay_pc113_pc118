<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AllowedRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('login'); // Redirect to login if user is not authenticated
        }

        // Check if the user's role is in the allowed roles
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request); // Proceed if role is allowed
        }

        // If the user doesn't have access, return a 403 Unauthorized error
        return abort(403, 'You do not have the necessary permissions to access this page.');
    }
}
