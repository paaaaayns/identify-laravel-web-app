<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function verifyPassword(Request $request)
    {
        $user = Auth::user();

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

    public function updatePassword(Request $request, string $user_id)
    {
        $authenticatedUser = Auth::user();

        $isMatch = Hash::check($request->current_password, $authenticatedUser->password);

        try {
            $validatedData = $request->validate([
                'current_password' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($isMatch) {
                        if (! $isMatch) {
                            $fail('The current password is incorrect.');
                        }
                    },
                ],
    
                'password' => [
                    'required',
                    'string',
                    Password::min(8)->mixedCase()->numbers()->symbols(),
                    'confirmed',
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted errors and try again.',
                'errors' => $e->errors(),
            ], 422);
        }

        $userToUpdate = User::where('user_id', $user_id)->first();
        $userToUpdate->password = Hash::make($validatedData['password']);
        $userToUpdate->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ], 200);
    }
}
