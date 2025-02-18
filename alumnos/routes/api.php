<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth-by-name', [AuthController::class, 'authByName'])->name('auth.by.name');

// Protected routes
Route::middleware(['auth:sanctum', \App\Http\Middleware\CheckAuth::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [UserController::class, 'show'])->name('user.show');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/welcome', function () {
        return response()->json(['message' => 'Bienvenido, estás autenticado']);
    })->name('welcome');
    Route::get('/user-data', [UserController::class, 'userData'])->name('user.data');
});