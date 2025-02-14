<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
            'user' => Auth::user()
        ], 200);
    }

    public function show()
    {
        return response()->json(Auth::user());
    }
}