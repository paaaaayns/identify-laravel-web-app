<?php

namespace App\Observers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OpdRegistrationObserver
{
    //
    public function creating(Opd $opd)
    {
        // The ID is not available here yet.
    }

    public function created(Opd $opd)
    {
        try {
            // Update the user_id once the ID is available
            $opd->user_id = 'O-' . str_pad($opd->id, 5, '0', STR_PAD_LEFT);
            $opd->saveQuietly(); // Avoid infinite loop by saving without triggering events

            // Create a new user record
            $user = User::create([
                'user_id' => $opd->user_id, // Use the custom user_id
                'username' => $opd->user_id, // Use the custom username
                'password' => Hash::make('opd'), // Default password or logic to generate a secure password
                'email' => $opd->email, // Use the email of the doctor or opd
                'type' => 'OPD', // Set the type (e.g., doctor, opd)
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating User for OPD: ' . $e->getMessage(), [
                'opd_id' => $opd->id,
                'email' => $opd->email,
            ]);

            // Delete the opd record since User creation failed
            $opd->delete();
        }
    }
}
