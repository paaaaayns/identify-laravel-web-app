<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MedicalRecord extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function (MedicalRecord $medical_record) {
            try {
                $medical_record->medical_record_id = 'M-' . str_pad($medical_record->id, 8, '0', STR_PAD_LEFT);
                $medical_record->ulid = Str::ulid();
                $medical_record->saveQuietly();
            } catch (\Exception $e) {
                Log::error('MedicalRecord@booted: Error creating User for opd: ' . $e->getMessage(), [
                    'medical_record_id' => $medical_record->medical_record_id,
                ]);
            }
        });
    }

    public function queue(): BelongsTo
    {
        return $this->belongsTo(PatientQueue::class, 'queue_id', 'queue_id');
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id', 'user_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id');
    }
}
