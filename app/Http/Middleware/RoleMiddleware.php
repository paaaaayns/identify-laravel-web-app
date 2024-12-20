<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user's role matches the required role
            if (Auth::user()->role === $role) {
                return $next($request); // Allow access
            }
        }

        // Redirect if the role does not match
        return redirect('/')->with('error', 'You do not have access to this page');
    }
}