<?php

namespace App\Observers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OpdObserver
{
    /**
     * Handle the Opd "creating" event.
     *
     * @param  \App\Models\Opd  $opd
     * @return void
     */
    public function creating(Opd $opd)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the Opd "created" event.
     *
     * @param  \App\Models\Opd  $opd
     * @return void
     */
    public function created(Opd $opd)
    {
        try {
            // Generate a unique user_id based on the opd's ID
            $opd->user_id = 'O-' . str_pad($opd->id, 5, '0', STR_PAD_LEFT);
            $opd->ulid = Str::ulid();
            $opd->saveQuietly(); // Save without triggering model events

            // Create the associated user
            $user = User::create([
                'user_id' => $opd->user_id,  // Use the custom user_id
                'email' => $opd->email, // opd's email
                'password' => Hash::make('opd'), // Default password
                'role' => 'opd',  // Define user type
            ]);

            $user->assignRole('opd');

            Log::info('OpdObserver@created: OPD created successfully.', [
                'opd_id' => $opd->user_id,
            ]);

            // Send email verification notification
            // event(new Registered($user));
        } catch (\Exception $e) {
            // Log any issues during user creation
            Log::error('OpdObserver@created: Error creating User for opd: ' . $e->getMessage(), [
                'opd_id' => $opd->user_id,
                'email' => $opd->email,
            ]);

            // Delete the opd record to maintain data consistency
            $opd->delete();

            // Check if $user exists before deleting it
            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
