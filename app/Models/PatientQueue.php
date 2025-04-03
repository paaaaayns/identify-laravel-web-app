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
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function (PatientQueue $queue) {
            try {
                $queue->queue_id = 'Q-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
                $queue->ulid = Str::ulid();
                $queue->saveQuietly();
            } catch (\Exception $e) {
                Log::error('PatientQueue@booted: QError creating User for opd: ' . $e->getMessage(), [
                    'queue_id' => $queue->queue_id,
                    'opd_id' => $queue->opd_id,
                    'patient_id' => $queue->patient_id,
                ]);

                $queue->delete();
            }
        });
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'queue_id', 'queue_id');
    }
}
