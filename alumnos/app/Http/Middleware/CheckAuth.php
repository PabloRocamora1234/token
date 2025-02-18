<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        $publicRoutes = [
            'login',
            'register',
            'auth.by.name',
        ];

        if (in_array($request->route()->getName(), $publicRoutes)) {
            return $next($request);
        }

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
