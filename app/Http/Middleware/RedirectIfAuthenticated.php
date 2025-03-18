<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            // Redirect to profile if already logged in
            return redirect()->route('account.profile');
        }

        return $next($request);
    }
}
