<?php

namespace App\Observers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientRegistrationObserver
{
    //
    public function creating(Patient $patient)
    {
        // The ID is not available here yet.
    }

    public function created(Patient $patient)
    {
        // Update the user_id once the ID is available.
        $patient->user_id = 'O-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
        $patient->saveQuietly(); // Avoid infinite loop by saving without triggering events.

        // Create a new user record
        $user = User::create([
            'user_id' => $patient->user_id,  // Use the custom user_id
            'username' => $patient->user_id, // Use the custom username
            'password' => Hash::make('identify123'), // Default password or logic to generate a secure password
            'email' => $patient->email, // Use the email of the doctor or opd
            'type' => 'PATIENT',  // Set the type (e.g., doctor, opd)
        ]);
    }
}
