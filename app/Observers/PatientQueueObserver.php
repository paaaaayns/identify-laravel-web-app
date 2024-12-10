<?php

namespace App\Observers;

use App\Models\PatientQueue;

class PatientQueueObserver
{
    /**
     * Handle the PatientQueue "created" event.
     */
    public function created(PatientQueue $patientQueue): void
    {
        //
    }

    /**
     * Handle the PatientQueue "updated" event.
     */
    public function updated(PatientQueue $patientQueue): void
    {
        //
    }

    /**
     * Handle the PatientQueue "deleted" event.
     */
    public function deleted(PatientQueue $patientQueue): void
    {
        //
    }

    /**
     * Handle the PatientQueue "restored" event.
     */
    public function restored(PatientQueue $patientQueue): void
    {
        //
    }

    /**
     * Handle the PatientQueue "force deleted" event.
     */
    public function forceDeleted(PatientQueue $patientQueue): void
    {
        //
    }
}
