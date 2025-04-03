<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\PreRegisteredPatient;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();

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
                $medicalRecordsCount = MedicalRecord::where('patient_id', $user->user_id)
                    ->count();
                return view('auth.dashboard.patient', [
                    'medicalRecordsCount' => $medicalRecordsCount,
                ]);
            default:
                return abort(403);
        }
    }
}
