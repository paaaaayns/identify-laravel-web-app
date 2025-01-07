<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreRegisteredPatient extends Model
{
    /** @use HasFactory<\Database\Factories\PreRegisteredPatientFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        // When the patient is being created
        static::creating(function (PreRegisteredPatient $patient) {
            // No user_id yet; ID will be available after creation.
        });

        // After the patient is created
        static::created(function (PreRegisteredPatient $patient) {
            try {
                // Generate a unique user_id based on the patient's ID
                $patient->ulid = Str::ulid();
                $patient->saveQuietly(); // Save without triggering model events
            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating record for pre-registration: ' . $e->getMessage(), [
                    'patient_id' => $patient->id,
                    'email' => $patient->email,
                ]);

                // Delete the patient record to maintain data consistency
                $patient->delete();
            }
        });
    }
}
