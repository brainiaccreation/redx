<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\PermissionMap;

class GlobalPermissionMiddleware
{
    protected $except = [
        'admin.login',
        'admin.login.submit',
        'admin.logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $routeName = $request->route()->getName();

        if (in_array($routeName, $this->except)) {
            return $next($request);
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $permission = PermissionMap::getPermission($routeName);

        if (!$permission) {
            return $next($request);
        }

        if ($user->hasPermissionTo($permission)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}
