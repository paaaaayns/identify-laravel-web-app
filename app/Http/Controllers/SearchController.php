<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check user role and return the appropriate view
        switch ($user->type) {
            case 'ADMIN':
                return $this->showAdmin();

            case 'OPD':
                return view('dashboard.opd');
            case 'DOCTOR':
                return view('dashboard.doctor');
            case 'PATIENT':
                return view('dashboard.patient');
                // Add more roles if necessary
            default:
                return abort(403);  // Default dashboard view
        }
    }


    private function showAdmin()
    {
        $doctors = Doctor::latest()->get();
        $opds = Opd::latest()->get();
        $reg_patients = Patient::latest()->get();
        $pre_reg_patients = PreRegisteredPatient::latest()->get();

        return view('auth.admin.search', [
            'doctors' => $doctors,
            'opds' => $opds,
            'reg_patients' => $reg_patients,
            'pre_reg_patients' => $pre_reg_patients,
        ]);
    }
}
