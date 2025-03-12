<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\PreRegisteredPatient;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();
        // dd($user);

        // Check user role and return the appropriate view
        switch ($user->role) {
            case 'admin':
                $preRegPatientsCount = PreRegisteredPatient::count();
                $patientsCount = Patient::count();
                $opdsCount = Opd::count();
                $doctorsCount = Doctor::count();
                $ongoingQueuesCount = PatientQueue::whereNotIn('queue_status', ['Completed', 'Cancelled'])->count();
                $historyCount = PatientQueue::whereIn('queue_status', ['Completed', 'Cancelled'])->count();

                return view('auth.dashboard.admin', [
                    'preRegPatientsCount' => $preRegPatientsCount,
                    'patientsCount' => $patientsCount,
                    'opdsCount' => $opdsCount,
                    'doctorsCount' => $doctorsCount,
                    'ongoingQueuesCount' => $ongoingQueuesCount,
                    'historyCount' => $historyCount,
                ]);

            case 'opd':
                $preRegPatientsCount = PreRegisteredPatient::count();
                $patientsCount = Patient::count();
                $queuedPatientsCount = PatientQueue::whereBelongsTo($user, $user->role)
                    ->whereNotIn('queue_status', ['Completed', 'Cancelled'])
                    ->count();

                return view('auth.dashboard.opd', [
                    'preRegPatientsCount' => $preRegPatientsCount,
                    'patientsCount' => $patientsCount,
                    'queuedPatientsCount' => $queuedPatientsCount,
                ]);
            case 'doctor':
                $queuedPatientsCount = PatientQueue::whereNotIn('queue_status', ['Completed', 'Cancelled'])
                    ->wherebelongsto($user, $user->role)
                    ->count();

                return view('auth.dashboard.doctor', [
                    'queuedPatientsCount' => $queuedPatientsCount,
                ]);
            case 'patient':
                return view('auth.dashboard.patient');
                // Add more roles if necessary
            default:
                return abort(403);  // Default dashboard view
        }
    }
}
