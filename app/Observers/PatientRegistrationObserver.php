<?php

namespace App\Observers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatientRegistrationObserver
{
    //
    public function creating(Patient $patient)
    {
        // The ID is not available here yet.
    }

    public function created(Patient $patient)
    {
        try {
            // Update the user_id once the ID is available.
            $patient->user_id = 'P-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
            $patient->saveQuietly(); // Avoid infinite loop by saving without triggering events.

            // Create a new user record
            $user = User::create([
                'user_id' => $patient->user_id,  // Use the custom user_id
                'username' => $patient->user_id, // Use the custom username
                'password' => Hash::make('identify123'), // Default password or logic to generate a secure password
                'email' => $patient->email, // Use the email of the patient
                'type' => 'PATIENT',  // Set the type (e.g., patient, opd)
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating User for OPD: ' . $e->getMessage(), [
                'opd_id' => $patient->id,
                'email' => $patient->email,
            ]);

            // Delete the patient record since User creation failed
            $patient->delete();
        }
    }
}
