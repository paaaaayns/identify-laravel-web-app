<?php

namespace App\Observers;

use App\Models\Doctor;

class DoctorRegistrationObserver
{
    public function creating(Doctor $doctor)
    {
        // The ID is not available here yet.
    }

    public function created(Doctor $doctor)
    {
        // Update the user_id once the ID is available.
        $doctor->user_id = 'D-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
        $doctor->saveQuietly(); // Avoid infinite loop by saving without triggering events.
    }
}