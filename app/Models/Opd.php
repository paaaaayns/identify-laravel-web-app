<?php

namespace App\Models;

use App\Models\PatientQueue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    /** @use HasFactory<\Database\Factories\OpdFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function credentials(): MorphOne
    {
        return $this->morphOne(User::class, 'personalInfo', 'role', 'user_id', 'user_id');
    }

    public function patientQueue()
    {
        return $this->hasMany(PatientQueue::class, 'opd_id', 'user_id');
    }
}
