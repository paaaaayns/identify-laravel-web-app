<?php

namespace App\Models;

use App\Models\PatientQueue;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        // When the patient is being created
        static::creating(function (Patient $patient) {
            // No user_id yet; ID will be available after creation.
        });

        // After the patient is created
        static::created(function (Patient $patient) {
            try {
                // Generate a unique user_id based on the patient's ID
                $patient->user_id = 'P-' . str_pad($patient->id, 5, '0', STR_PAD_LEFT);
                $patient->saveQuietly(); // Save without triggering model events

                // Delete from PreregisteredPatient table
                $pre_reg = PreRegisteredPatient::where('email', $patient->email)->first();
                if ($pre_reg) {
                    $pre_reg->delete();
                }

                // Create the associated user
                $user = User::create([
                    'user_id' => $patient->user_id,  // Use the custom user_id
                    'email' => $patient->email, // patient's email
                    'password' => Hash::make('patient'), // Default password
                    'role' => 'patient',  // Define user type
                ]);

                $user->assignRole('patient');

                // Send email verification notification
                // event(new Registered($user));
            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating User for patient: ' . $e->getMessage(), [
                    'patient_id' => $patient->id,
                    'email' => $patient->email,
                ]);

                // Delete the patient record to maintain data consistency
                $patient->delete();
                $user->delete();
            }
        });
    }

    public function credentials(): MorphOne
    {
        return $this->morphOne(User::class, 'personalInfo', 'role', 'user_id', 'user_id');
    }

    public function medicalHistory(): HasMany
    {
        return $this->hasMany(PatientQueue::class, 'queue_id', 'user_id'); // Adjust based on actual foreign key
    }
}
