<?php

namespace App\Observers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

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

            // Update the queue with the medical record ID
            $queue = $medicalRecord->queue;
            $queue->medical_record_id = $medicalRecord->medical_record_id;
            $queue->saveQuietly(); // Save without triggering model events

            // generate a PDF file using spatie/laravel-pdf
            $record = $medicalRecord->load(['patient', 'doctor', 'opd']);
            $patient_ulid = $record->patient->ulid;
            $record_ulid = $record->ulid;

            $pdfPath = "patients/{$patient_ulid}/medical-records/{$record_ulid}/{$record_ulid}.pdf";

            Pdf::view('pdfs.medical-record', ['record' => $record])
                ->disk('public')
                ->save($pdfPath);

            Log::info('MedicalRecordObserver@created: Medical Record created successfully.', [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);
        } catch (\Exception $e) {
            // Log any issues during record creation
            Log::error('MedicalRecordObserver@created: Error creating Medical Record: ' . $e->getMessage(), [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            // Delete the record to maintain data consistency
            $medicalRecord->delete();
        }
    }
}
