<?php

namespace App\Observers;

use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PatientObserver
{
    /**
     * Handle the Patient "creating" event.
     *
     * @param  \App\Models\Patient  $patient
     * @return void
     */
    public function creating(Patient $patient)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the Patient "created" event.
     *
     * @param  \App\Models\Patient  $patient
     * @return void
     */
    public function created(Patient $patient)
    {
        try {
            // Generate a unique user_id based on the patient's ID
            $patient->user_id = 'P-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
            // $patient->ulid = Str::ulid();
            $patient->saveQuietly(); // Save without triggering model events

            // Delete from PreregisteredPatient table
            $pre_reg = PreRegisteredPatient::where('email', $patient->email)->first();
            if ($pre_reg) {
                $pre_reg->delete();
            }

            // Create the associated user
            $user = User::create([
                'user_id' => $patient->user_id,  // Use the custom user_id
                'email' => $patient->email, // patient's email
                'password' => Hash::make('patient'), // Default password
                'role' => 'patient',  // Define user type
            ]);

            $user->assignRole('patient');

            Log::info('Patient created successfully.', [
                'patient_id' => $patient->user_id,
            ]);

            // Send email verification notification
            // event(new Registered($user));
        } catch (\Exception $e) {
            // Log any issues during user creation
            Log::error('Error creating User for patient: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
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
