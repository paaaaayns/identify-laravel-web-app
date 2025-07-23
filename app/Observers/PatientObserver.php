<?php

namespace App\Observers;

use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatientObserver
{
    public function created(Patient $patient)
    {
        try {
            $generatedId = 'P-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
            $patient->user_id = $generatedId;
            $patient->saveQuietly();

            $pre_reg = PreRegisteredPatient::where('ulid', $patient->ulid)->first();
            if ($pre_reg) {
                $pre_reg->delete();
            }

            $user = User::create([
                'user_id' => $patient->user_id,
                'email' => $patient->email,
                'password' => Hash::make('Password@123'),
                'role' => 'patient',
            ]);

            $user->assignRole('patient');

            Log::info('PatientObserver@created: Patient created successfully.', [
                'patient_id' => $patient->user_id,
            ]);

            event(new Registered($user));
        } catch (\Exception $e) {
            Log::error('PatientObserver@created: Error creating User for patient: ' . $e->getMessage(), [
                'patient_ulid' => $patient->ulid,
                'email' => $patient->email,
            ]);

            $patient->delete();

            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
