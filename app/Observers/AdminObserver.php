<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminObserver
{
    /**
     * Handle the Admin "creating" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function creating(Admin $admin)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the Admin "created" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        try {
            // Generate a unique user_id based on the admin's ID
            $admin->user_id = 'A-' . str_pad($admin->id, 5, '0', STR_PAD_LEFT);
            $admin->ulid = Str::ulid();
            $admin->saveQuietly(); // Save without triggering model events

            // Create the associated user
            $user = User::create([
                'user_id' => $admin->user_id,  // Use the custom user_id
                'email' => $admin->email, // admin's email
                'password' => Hash::make('admin'), // Default password
                'role' => 'admin',  // Define user type
            ]);

            $user->assignRole('admin');

            Log::info('AdminObserver@created: Admin created successfully.', [
                'admin_id' => $admin->user_id,
            ]);

            // Send email verification notification
            // event(new Registered($user));
        } catch (\Exception $e) {
            // Log any issues during user creation
            Log::error('AdminObserver@created: Error creating User for admin: ' . $e->getMessage(), [
                'admin_id' => $admin->user_id,
                'email' => $admin->email,
            ]);

            // Optional: Delete the admin record to maintain data consistency
            $admin->delete();

            // Check if $user exists before deleting it
            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
