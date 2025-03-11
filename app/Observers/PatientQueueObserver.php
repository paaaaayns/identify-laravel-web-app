<?php

namespace App\Observers;

use App\Models\MedicalRecord;
use App\Models\PatientQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function updated(PatientQueue $queue)
    {
        if ($queue->queue_status === 'Completed') {
            Log::info('PatientQueueObserver@updated: Creating medical record for queue ID: ' . $queue->queue_id);
            $queue = PatientQueue::find($queue->id);

            try {
                MedicalRecord::create([
                    'medical_record_id' => 'M-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
                    'queue_id' => $queue->queue_id,
                    'patient_id' => $queue->patient_id,
                    'doctor_id' => $queue->doctor_id,
                    'opd_id' => $queue->opd_id,
                    'height' => $queue->height,
                    'weight' => $queue->weight,
                    'blood_pressure' => $queue->blood_pressure,
                    'temperature' => $queue->temperature,
                    'pulse_rate' => $queue->pulse_rate,
                    'respiration_rate' => $queue->respiration_rate,
                    'o2_sat' => $queue->o2_sat,
                    'other' => $queue->other,
                    'primary_complaint' => $queue->primary_complaint,
                    'duration_of_symptoms' => $queue->duration_of_symptoms,
                    'intensity_and_frequency' => $queue->intensity_and_frequency,
                    'findings' => $queue->findings,
                    'diagnosis' => $queue->diagnosis,
                    'recommended_treatment' => $queue->recommended_treatment,
                    'follow_up_instructions' => $queue->follow_up_instructions,
                    'referrals' => $queue->referrals,
                    'doctor_notes' => $queue->doctor_notes,
                ]);
            } catch (\Exception $e) {
                Log::error('PatientQueueObserver@updated: Error creating Medical Record: ' . $e->getMessage(), [
                    'queue_id' => $queue->id,
                    'patient_id' => $queue->patient_id,
                ]);
            }
        }
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
