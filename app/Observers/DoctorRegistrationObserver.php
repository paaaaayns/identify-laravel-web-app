<?php

namespace App\Observers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DoctorRegistrationObserver
{
    public function creating(Doctor $doctor)
    {
        // The ID is not available here yet.
    }

    public function created(Doctor $doctor)
    {
        try {
            // Update the user_id once the ID is available.
            $doctor->user_id = 'D-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
            $doctor->saveQuietly(); // Avoid infinite loop by saving without triggering events.

            // Create a new user record
            $user = User::create([
                'user_id' => $doctor->user_id,  // Use the custom user_id
                'username' => $doctor->user_id, // Use the custom username
                'password' => Hash::make('doctor'), // Default password or logic to generate a secure password
                'email' => $doctor->email, // Use the email of the doctor or opd
                'type' => 'DOCTOR',  // Set the type (e.g., doctor, opd)
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating User for DOCTOR: ' . $e->getMessage(), [
                'opd_id' => $doctor->id,
                'email' => $doctor->email,
            ]);

            // Delete the doctor record since User creation failed
            $doctor->delete();
        }
    }
}
