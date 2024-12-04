<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientQueue extends Model
{
    /** @use HasFactory<\Database\Factories\PatientQueueFactory> */
    use HasFactory;
    protected $guarded = [];
}
