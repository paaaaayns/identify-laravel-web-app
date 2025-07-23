<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show()
    {
        $authenticatedUser = Auth::user();
        $profile = $authenticatedUser->profile;
        Log::info('ProfileController@show: ', [
            'profile' => $profile
        ]);

        return view("auth.users.profile.layout", [
            'profile' => $profile
        ]);
    }
}
