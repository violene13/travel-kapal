<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::guard('web')->check()) {
            abort(403, 'Anda belum login sebagai admin');
        }

        if (Auth::guard('web')->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}
