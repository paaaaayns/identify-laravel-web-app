<?php

namespace App\Observers;

use App\Models\IrisBiometrics;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PatientObserver
{
    /**
     * Handle the Patient "created" event.
     *
     * @param  \App\Models\Patient  $patient
     * @return void
     */
    public function created(Patient $patient)
    {
        try {
            $generatedId = 'P-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
            $patient->user_id = $generatedId;
            $patient->saveQuietly();

            $pre_reg = PreRegisteredPatient::where('email', $patient->email)->first();
            if ($pre_reg) {
                $pre_reg->delete();
            }

            $user = User::create([
                'user_id' => $patient->user_id,
                'email' => $patient->email,
                'password' => Hash::make('patient'),
                'role' => 'patient',
            ]);

            $user->assignRole('patient');

            Log::info('PatientObserver@created: Patient created successfully.', [
                'patient_id' => $patient->user_id,
            ]);

            // Send email verification notification
            // event(new Registered($user));
        } catch (\Exception $e) {
            Log::error('PatientObserver@created: Error creating User for patient: ' . $e->getMessage(), [
                'patient_ulid' => $patient->ulid,
                'email' => $patient->email,
            ]);

            // Delete the patient record to maintain data consistency
            $patient->delete();

            // Check if $user exists before deleting it
            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
