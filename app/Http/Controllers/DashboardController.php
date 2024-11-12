<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function show(){
        // Get the authenticated user
        $user = Auth::user();
        
        // Check user role and return the appropriate view
        switch ($user->type) {
            case 'ADMIN':
                return view('dashboard.admin');
            case 'OPD':
                return view('dashboard.opd');
            case 'DOCTOR':
                return view('dashboard.doctor');
            case 'PATIENT':
                return view('dashboard.patient');
            // Add more roles if necessary
            default:
                return view('dashboard.default');  // Default dashboard view
        }
    }

}
