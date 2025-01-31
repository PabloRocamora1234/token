<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = Auth::user();
        
        if (method_exists($user, 'tokens')) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
        }

        Auth::logout();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    public function profile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        return response()->json([
            'user' => Auth::user()
        ], 200);
    }

    /**
     * Display the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json(Auth::user());
    }
}