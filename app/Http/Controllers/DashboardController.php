<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check user role and return the appropriate view
        switch ($user->type) {
            case 'ADMIN':
                $preRegPatientsCount = PreRegisteredPatient::count();
                $recentPreRegPatientsCount = PreRegisteredPatient::where('created_at', '>=', Carbon::now()->subDay())->count();

                $patientsCount = Patient::count();
                $recentPatientsCount = Patient::where('created_at', '>=', Carbon::now()->subDay())->count();

                $opdsCount = Opd::count();
                $recentOpdsCount = Opd::where('created_at', '>=', Carbon::now()->subDay())->count();

                $doctorsCount = Doctor::count();
                $recentDoctorsCount  = Doctor::where('created_at', '>=', Carbon::now()->subDay())->count();

                return view('auth.dashboard.admin', [
                    'preRegPatientsCount' => $preRegPatientsCount,
                    'recentPreRegPatientsCount' => $recentPreRegPatientsCount,

                    'patientsCount' => $patientsCount,
                    'recentPatientsCount' => $recentPatientsCount,

                    'opdsCount' => $opdsCount,
                    'recentOpdsCount' => $recentOpdsCount,

                    'doctorsCount' => $doctorsCount,
                    'recentDoctorsCount' => $recentDoctorsCount,
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
}
