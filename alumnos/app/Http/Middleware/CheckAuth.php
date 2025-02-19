<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

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

        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $user = $accessToken->tokenable;
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 401);
        }

        auth()->login($user);
        
        return $next($request);
    }
}
