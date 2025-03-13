<?php

namespace App\Models;

use App\Models\PatientQueue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function credentials(): MorphOne
    {
        return $this->morphOne(User::class, 'personalInfo', 'role', 'user_id', 'user_id');
    }

    public function medicalHistory(): HasMany
    {
        return $this->hasMany(PatientQueue::class, 'queue_id', 'user_id'); // Adjust based on actual foreign key
    }

    public function irisBiometrics(): HasMany
    {
        return $this->hasMany(IrisBiometrics::class, 'patient_ulid', 'ulid');
    }
}
