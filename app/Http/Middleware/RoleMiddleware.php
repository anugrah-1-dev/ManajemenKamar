<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || !$request->user()->hasRole($role)) {
            abort(403, 'Akses ditolak. Kamu bukan ' . $role . '.');
        }

        return $next($request);
    }
}
