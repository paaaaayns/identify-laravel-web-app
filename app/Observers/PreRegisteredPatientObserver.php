<?php

namespace App\Observers;

use App\Mail\PreRegistrationMail;
use App\Models\PreRegisteredPatient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PreRegisteredPatientObserver
{
    /**
     * Handle the PreRegisteredPatient "creating" event.
     *
     * @param  \App\Models\PreRegisteredPatient  $patient
     * @return void
     */
    public function creating(PreRegisteredPatient $patient)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the PreRegisteredPatient "created" event.
     *
     * @param  \App\Models\PreRegisteredPatient  $patient
     * @return void
     */
    public function created(PreRegisteredPatient $patient)
    {
        try {
            // Generate a unique ULID for the pre-registered patient
            $patient->ulid = Str::ulid();
            $patient->saveQuietly(); // Save without triggering model events

            Log::info('PreRegisteredPatientObserver@updated: Pre-registered patient created successfully.', [
                'patient_id' => $patient->ulid,
            ]);

            $data = [
                'code' => $patient->pre_registration_code,
                'trackingLink' => route('pre-reg.tracking.search'),
            ];

            Mail::to($patient->email)->send(new PreRegistrationMail($data));
        } catch (\Exception $e) {
            // Log any issues during pre-registration record creation
            Log::error('PreRegisteredPatientObserver@updated: Error creating record for pre-registration: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
                'email' => $patient->email,
            ]);

            // Delete the pre-registered patient record to maintain data consistency
            $patient->delete();
        }
    }
}
