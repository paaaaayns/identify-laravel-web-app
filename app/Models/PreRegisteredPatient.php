<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PreRegisteredPatient extends Model
{
    /** @use HasFactory<\Database\Factories\PreRegisteredPatientFactory> */
    use HasFactory;
    use HasUlids;
    protected $guarded = [];
}
