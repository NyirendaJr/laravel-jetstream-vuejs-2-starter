<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Inertia\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (auth()->user()->is_active == 0)) {
            auth('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = "Your account has been locked, contact your system Administrator to unlock your account.";

            return Inertia::render('Auth/Login')->with(['loginError' => $message]);

        }

        return $next($request);
    }
}
