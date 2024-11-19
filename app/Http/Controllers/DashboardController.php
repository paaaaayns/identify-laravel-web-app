<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
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
                $doctors = Doctor::latest()->get();
                $opds = Opd::latest()->get();
                $reg_patients = Patient::latest()->get();
                $pre_reg_patients = PreRegisteredPatient::latest()->get();

                return view('auth.dashboard.admin', [
                    'doctors' => $doctors,
                    'opds' => $opds,
                    'reg_patients' => $reg_patients,
                    'pre_reg_patients' => $pre_reg_patients,
                ]);

            case 'OPD':
                return view('auth.dashboard.opd');
            case 'DOCTOR':
                return view('auth.dashboard.doctor');
            case 'PATIENT':
                return view('auth.dashboard.patient');
            // Add more roles if necessary
            default:
                return abort(403);  // Default dashboard view
        }
    }

    private function getPreRegisteredPatients($firstName)
    {
        return Patient::where(function($query) use ($firstName) {
            $query->where('first_name', 'like', "%$firstName%")
                  ->orWhere('middle_name', 'like', "%$firstName%")
                  ->orWhere('last_name', 'like', "%$firstName%");
        })
        ->whereNull('registered_at')
        ->get();
    }

}
