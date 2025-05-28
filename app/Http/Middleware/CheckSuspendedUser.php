<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuspendedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_suspended == 1) {
            Auth::logout();

            return redirect()->back()->with([
                'error' => 'Your account has been suspended.'
            ]);
        }

        return $next($request);
    }
}
