<?php

namespace App\Observers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorObserver
{
    /**
     * Handle the Doctor "creating" event.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return void
     */
    public function creating(Doctor $doctor)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the Doctor "created" event.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return void
     */
    public function created(Doctor $doctor)
    {
        try {
            // Generate a unique user_id based on the doctor's ID
            $doctor->user_id = 'D-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
            $doctor->ulid = Str::ulid();
            $doctor->saveQuietly(); // Save without triggering model events

            // Create the associated user
            $user = User::create([
                'user_id' => $doctor->user_id,  // Use the custom user_id
                'email' => $doctor->email, // doctor's email
                'password' => Hash::make('Password@123'), // Default password
                'role' => 'doctor',  // Define user type
            ]);

            $user->assignRole('doctor');

            Log::info('DoctorObserver@created: Doctor created successfully.', [
                'doctor_id' => $doctor->user_id,
            ]);

            // Send email verification notification
            // event(new Registered($user));
        } catch (\Exception $e) {
            // Log any issues during user creation
            Log::error('DoctorObserver@created: Error creating User for doctor: ' . $e->getMessage(), [
                'doctor_id' => $doctor->user_id,
                'email' => $doctor->email,
            ]);

            // Delete the doctor and user record to maintain data consistency
            $doctor->delete();

            // Check if $user exists before deleting it
            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
