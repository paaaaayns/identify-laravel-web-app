<?php

namespace App\Models;

use App\Models\PatientQueue;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function credentials(): MorphOne
    {
        return $this->morphOne(User::class, 'personalInfo', 'role', 'user_id', 'user_id');
    }

    public function patientQueue(): HasMany
    {
        return $this->hasMany(PatientQueue::class, 'doctor_id', 'user_id');
    }
}
