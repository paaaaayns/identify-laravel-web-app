<?php

namespace App\Observers;

use App\Models\MedicalRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

            // Update the queue with the medical record ID
            $queue = $medicalRecord->queue;
            $queue->medical_record_id = $medicalRecord->medical_record_id;
            $queue->saveQuietly(); // Save without triggering model events
            
            $patient = $medicalRecord->patient;

            Log::info('MedicalRecordObserver@created: Medical Record created successfully.', [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            try {
                // Generate a customized PDF
                $pdf = Pdf::loadView('pdfs.medical-record', ['medicalRecord' => $medicalRecord]);

                $RecordDirectory = "patients/{$patient->ulid}/medical_records/{$medicalRecord->ulid}";
                $RecordFileName = "{$medicalRecord->ulid}.pdf";
                $RecordFilePath = "{$RecordDirectory}/{$RecordFileName}";

                // Save the PDF to storage
                $fileName = "medical_records/{$medicalRecord->ulid}.pdf";
                $file = Storage::disk('public')->put($RecordFilePath, $pdf->output());

                Log::info('MedicalRecordObserver@created: PDF generated successfully.', [
                    'medical_record_id' => $medicalRecord->medical_record_id,
                    'file_name' => $fileName,
                ]);
            } catch (\Exception $e) {
                // Log the error
                Log::error('MedicalRecordObserver@created: Error generating PDF: ' . $e->getMessage(), [
                    'medical_record_id' => $medicalRecord->medical_record_id ?? 'N/A',
                ]);
            }
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
