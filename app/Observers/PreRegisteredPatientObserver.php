<?php

namespace App\Observers;

use App\Mail\PreRegistrationMail;
use App\Models\PreRegisteredPatient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PreRegisteredPatientObserver
{
    public function created(PreRegisteredPatient $patient)
    {
        try {
            $patient->ulid = Str::ulid();
            $patient->saveQuietly();

            Log::info('PreRegisteredPatientObserver@updated: Pre-registered patient created successfully.', [
                'patient_id' => $patient->ulid,
            ]);

            $data = [
                'code' => $patient->pre_registration_code,
                'trackingLink' => route('pre-reg.tracking.search'),
            ];

            // DEV NOTE (TESTING): Comment out the line below to prevent sending emails during testing
            Mail::to($patient->email)->send(new PreRegistrationMail($data));
        } catch (\Exception $e) {
            Log::error('PreRegisteredPatientObserver@updated: Error creating record for pre-registration: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
                'email' => $patient->email,
            ]);

            $patient->delete();
        }
    }
}
