<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $roleId
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->user()->hasRole($role)) {
            return $next($request);
        }

        throw UnauthorizedException::forRoles([$role]);
    }
    // public function handle(Request $request, Closure $next, $roles)
    // {
    //     $user = auth()->user();
    //     if ($user && $user->hasAnyRole($roles)) {
    //         return $next($request);
    //     }

    // throw UnauthorizedException::forRoles($roles);
    // if (!Auth::check() || Auth::user()->role_id != $roleId) {
    //     if ($request->expectsJson()) {
    //         return response()->json(['message' => 'Unauthorized. You do not have permission to access this resource.'], 403);
    //     }
    //     $user = auth()->user();


    //     return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    // }

    // return $next($request);
    // }
}
