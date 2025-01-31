<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Ensure this is POST
    Route::get('/user', [UserController::class, 'show'])->name('user.show'); // Ensure this is GET
    Route::get('/profile', [UserController::class, 'profile'])->name('profile'); // Ensure this is GET
    Route::get('/welcome', function () {
        return response()->json(['message' => 'Bienvenido, estás autenticado']);
    })->name('welcome'); // Ensure this is GET
});