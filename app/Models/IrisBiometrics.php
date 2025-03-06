<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IrisBiometrics extends Model
{
    /** @use HasFactory<\Database\Factories\IrisBiometricsFactory> */
    use HasFactory;

    protected $guarded = [];

    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id');
    }
}
