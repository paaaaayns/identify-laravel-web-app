<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminRegistrationObserver
{
    public function creating(Admin $admin)
    {
        // The ID is not available here yet.
    }

    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        try {
            // Update the user_id once the ID is available.
            $admin->user_id = 'A-' . str_pad($admin->id, 5, '0', STR_PAD_LEFT);
            $admin->saveQuietly(); // Avoid infinite loop by saving without triggering events.

            // Create a new user record
            $user = User::create([
                'user_id' => $admin->user_id,  // Use the custom user_id
                'username' => $admin->user_id, // Use the custom username
                'password' => Hash::make('admin'), // Default password or logic to generate a secure password
                'email' => $admin->email, // Use the email of the admin or opd
                'type' => 'ADMIN',  // Set the type (e.g., admin, opd)
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating User for Admin: ' . $e->getMessage(), [
                'user_id' => $admin->id,
                'email' => $admin->email,
            ]);

            // Delete the admin record since User creation failed
            $admin->delete();
        }
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
