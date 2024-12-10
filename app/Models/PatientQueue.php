<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PatientQueue extends Model
{
    /** @use HasFactory<\Database\Factories\PatientQueueFactory> */
    use HasFactory;
    protected $guarded = [];

    // Boot method to generate queue_id before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->queue_id = 'Q-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id'); // Adjust based on actual foreign key
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); // Adjust based on actual foreign key
    }
}
