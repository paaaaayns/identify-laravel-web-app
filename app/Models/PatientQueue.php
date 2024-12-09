<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientQueue extends Model
{
    /** @use HasFactory<\Database\Factories\PatientQueueFactory> */
    use HasFactory;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id'); // Adjust based on actual foreign key
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); // Adjust based on actual foreign key
    }
}
