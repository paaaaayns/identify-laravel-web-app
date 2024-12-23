<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        // When the admin is being created
        static::creating(function (Admin $admin) {
            // No user_id yet; ID will be available after creation.
        });

        // After the admin is created
        static::created(function (Admin $admin) {
            try {
                // Generate a unique user_id based on the admin's ID
                $admin->user_id = 'A-' . str_pad($admin->id, 5, '0', STR_PAD_LEFT);
                $admin->ulid = Str::ulid();
                $admin->saveQuietly(); // Save without triggering model events

                // Create the associated user
                $user = User::create([
                    'user_id' => $admin->user_id,  // Use the custom user_id
                    'username' => $admin->user_id, // Use the custom username
                    'password' => Hash::make('admin'), // Default password
                    'email' => $admin->email, // admin's email
                    'role' => 'admin',  // Define user type
                ]);

                $user->assignRole('admin', 'opd', 'doctor', 'patient');

                // Send email verification notification
                // event(new Registered($user));
            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating User for admin: ' . $e->getMessage(), [
                    'admin_id' => $admin->user_id,
                    'email' => $admin->email,
                ]);

                // Delete the admin record to maintain data consistency
                $admin->delete();
            }
        });
    }
}
