<?php

namespace App\Models;

use App\Models\PatientQueue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    /** @use HasFactory<\Database\Factories\OpdFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        // When the opd is being created
        static::creating(function (Opd $opd) {
            // No user_id yet; ID will be available after creation.
        });

        // After the opd is created
        static::created(function (Opd $opd) {
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

                // Send email verification notification
                // event(new Registered($user));
            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating User for opd: ' . $e->getMessage(), [
                    'opd_id' => $opd->user_id,
                    'email' => $opd->email,
                ]);

                // Delete the opd record to maintain data consistency
                $opd->delete();
                $user->delete();
            }
        });
    }

    public function credentials(): MorphOne
    {
        return $this->morphOne(User::class, 'personalInfo', 'role', 'user_id', 'user_id');
    }

    public function patientQueue()
    {
        return $this->hasMany(PatientQueue::class, 'opd_id', 'user_id'); // Adjust based on actual foreign key
    }
}
