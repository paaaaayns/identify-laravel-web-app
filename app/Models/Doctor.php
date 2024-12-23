<?php

namespace App\Models;

use App\Models\PatientQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        // When the doctor is being created
        static::creating(function (Doctor $doctor) {
            // No user_id yet; ID will be available after creation.
        });

        // After the doctor is created
        static::created(function (Doctor $doctor) {
            try {
                // Generate a unique user_id based on the doctor's ID
                $doctor->user_id = 'D-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
                $doctor->ulid = Str::ulid();
                $doctor->saveQuietly(); // Save without triggering model events

                // Create the associated user
                $user = User::create([
                    'user_id' => $doctor->user_id,  // Use the custom user_id
                    'username' => $doctor->user_id, // Use the custom username
                    'password' => Hash::make('doctor'), // Default password
                    'email' => $doctor->email, // doctor's email
                    'role' => 'doctor',  // Define user type
                ]);

                $user->assignRole('doctor');

                // Send email verification notification
                // event(new Registered($user));
            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating User for doctor: ' . $e->getMessage(), [
                    'doctor_id' => $doctor->user_id,
                    'email' => $doctor->email,
                ]);

                // Delete the doctor record to maintain data consistency
                $doctor->delete();
                $user->delete();
            }
        });
    }

    public function medicalHistory()
    {
        return $this->hasMany(PatientQueue::class, 'doctor_id'); // Adjust based on actual foreign key
    }
}
