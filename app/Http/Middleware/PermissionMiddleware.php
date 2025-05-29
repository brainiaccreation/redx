<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = auth()->user();

        // Normalize permissions to an array
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        // Check if user is authenticated and has any of the specified permissions
        if ($user && $user->hasAnyPermission($permissions)) {
            return $next($request);
        }

        // Throw unauthorized exception
        throw UnauthorizedException::forPermissions($permissions);
    }
}
