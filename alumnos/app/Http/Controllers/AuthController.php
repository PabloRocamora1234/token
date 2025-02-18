<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        // Delete all tokens for the current user
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function authByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::check()) {
            return response()->json(['message' => 'User already logged in'], 200);
        }

        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}