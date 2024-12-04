<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function verifyPassword(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user
        // dd($user);

        // Validate the password
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 401);
        }
    }
}
