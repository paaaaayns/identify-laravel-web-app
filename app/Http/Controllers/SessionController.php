<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        // dd('hello');
        return view('auth.login');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(){
        // dd('hello');


        // validate
        $validatedData = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // dd($validatedData);

        // attempt to log in 
        if (!Auth::attempt($validatedData)) {
            throw ValidationException::withMessages([
                'email' => "Credentials doesn't match"
            ]);
        };

        // regenerate session token
        request()->session()->regenerate();
        
         // get the authenticated user
        $user = Auth::user();
        // dd($user->type);

        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(){
        // dd('logout');

        Auth::logout();

        return redirect('/login');
    }
}
