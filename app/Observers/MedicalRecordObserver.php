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

            Log::info('Medical Record created successfully.', [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            try {
                // Generate a customized PDF
                $pdf = Pdf::loadView('pdfs.medical-record', ['medicalRecord' => $medicalRecord]);

                // Save the PDF to storage
                $fileName = "medical_records/{$medicalRecord->ulid}.pdf";
                Storage::put($fileName, $pdf->output());
                
                Log::info('PDF generated successfully.', [
                    'medical_record_id' => $medicalRecord->medical_record_id,
                    'file_name' => $fileName,
                ]);

            } catch (\Exception $e) {
                // Log the error
                Log::error('Error generating PDF: ' . $e->getMessage(), [
                    'medical_record_id' => $medicalRecord->medical_record_id ?? 'N/A',
                ]);
            }
        } catch (\Exception $e) {
            // Log any issues during record creation
            Log::error('Error creating Medical Record: ' . $e->getMessage(), [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            // Delete the record to maintain data consistency
            $medicalRecord->delete();
        }
    }
}
