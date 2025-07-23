<?php

namespace App\Observers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;

class MedicalRecordObserver
{
    public function created(MedicalRecord $medicalRecord)
    {
        try {
            $medicalRecord->medical_record_id = 'M-' . str_pad($medicalRecord->id, 8, '0', STR_PAD_LEFT);
            $medicalRecord->ulid = $medicalRecord->queue->ulid;
            $medicalRecord->saveQuietly();

            $queue = $medicalRecord->queue;
            $queue->medical_record_id = $medicalRecord->medical_record_id;
            $queue->saveQuietly();

            $record = $medicalRecord->load(['patient', 'doctor', 'opd']);
            $patient_ulid = $record->patient->ulid;
            $record_ulid = $record->ulid;

            $pdfPath = "patients/{$patient_ulid}/medical-records/{$record_ulid}/{$record_ulid}.pdf";

            Pdf::view('pdfs.medical-record', ['record' => $record])
                ->disk('public')
                ->save($pdfPath);
        } catch (\Exception $e) {
            Log::error('MedicalRecordObserver@created: Error creating Medical Record: ' . $e->getMessage(), [
                'medical_record_id' => $medicalRecord->medical_record_id,
            ]);

            $medicalRecord->delete();
        }
    }
}
