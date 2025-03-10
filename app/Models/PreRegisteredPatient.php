<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreRegisteredPatient extends Model
{
    /** @use HasFactory<\Database\Factories\PreRegisteredPatientFactory> */
    use HasFactory;
    protected $guarded = [];
}
