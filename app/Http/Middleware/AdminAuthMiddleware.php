<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if ($request->user()) {
            // Check if the authenticated user is an admin (adjust the logic as needed)
            if ($request->user()->role == 'admin' || $request->user()->role == 'superadmin') {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
