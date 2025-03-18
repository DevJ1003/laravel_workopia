<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectTo
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $route = 'account.login')
    {
        if (!Auth::check()) {
            // If user is not logged in, redirect to the specified route name
            return redirect()->route($route);
        }

        return $next($request);
    }
}
