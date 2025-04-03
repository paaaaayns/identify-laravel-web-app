<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if ($user) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function store()
    {
        $validatedData = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validatedData)) {
            throw ValidationException::withMessages([
                'email' => "Credentials doesn't match"
            ]);
        };

        request()->session()->regenerate();

        $user = Auth::user();

        return redirect('/dashboard');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
