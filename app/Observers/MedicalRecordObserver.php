<?php

namespace App\Observers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MedicalRecordObserver
{
    /**
     * Handle the MedicalRecord "creating" event.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return void
     */
    public function creating(MedicalRecord $medicalRecord)
    {
        // No user_id yet; ID will be available after creation.
    }

    /**
     * Handle the MedicalRecord "created" event.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return void
     */
    public function created(MedicalRecord $medicalRecord)
    {
        try {
            // Set the medical record ID and ULID after creation
            $medicalRecord->medical_record_id = 'M-' . str_pad($medicalRecord->id, 8, '0', STR_PAD_LEFT);
            $medicalRecord->ulid = Str::ulid();
            $medicalRecord->saveQuietly(); // Save without triggering model events

            Log::info('Medical Record created successfully.', [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);
        } catch (\Exception $e) {
            // Log any issues during record creation
            Log::error('Error creating User for opd: ' . $e->getMessage(), [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            // Delete the record to maintain data consistency
            $medicalRecord->delete();
        }
    }
}
