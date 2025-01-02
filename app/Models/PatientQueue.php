<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PatientQueue extends Model
{
    /** @use HasFactory<\Database\Factories\PatientQueueFactory> */
    use HasFactory;
    protected $guarded = [];

    // Hook into the creating and created model events
    protected static function booted()
    {
        static::creating(function (PatientQueue $queue) {
            // No user_id yet; ID will be available after creation.
        });

        static::created(function (PatientQueue $queue) {
            try {
                $queue->queue_id = 'Q-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
                $queue->ulid = Str::ulid();
                $queue->saveQuietly(); // Save without triggering model events

            } catch (\Exception $e) {
                // Log any issues during user creation
                Log::error('Error creating User for opd: ' . $e->getMessage(), [
                    'queue_id' => $queue->queue_id,
                    'opd_id' => $queue->opd_id,
                    'patient_id' => $queue->patient_id,
                ]);

                // Delete the opd record to maintain data consistency
                $queue->delete();
            }
        });
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'user_id'); // Adjust based on actual foreign key
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id'); // Adjust based on actual foreign key
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id'); // Adjust based on actual foreign key
    }
}
