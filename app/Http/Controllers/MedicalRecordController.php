<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;

class MedicalRecordController extends Controller
{
    public function index()
    {
        return view('auth.medical-record.index');
    }

    public function show(string $ulid)
    {
        $record = MedicalRecord::where('ulid', $ulid)->first();

        $patient = $record->patient;
        $doctor = $record->doctor;
        $opd = $record->opd;

        $RecordDirectory = "patients/{$patient->ulid}/medical_records/{$record->ulid}";
        $RecordFileName = "{$record->ulid}.pdf";
        $RecordFilePath = "{$RecordDirectory}/{$RecordFileName}";


        if (!file_exists(storage_path($RecordFilePath))) {
            $pdfPath = null;
            Log::info('MedicalRecordController@show: Medical Record PDF not found', ['ulid' => $ulid]);
        } else {
            $pdfPath = asset("storage/patients/{$patient->ulid}/medical_records/{$record->ulid}.pdf");
            Log::info('MedicalRecordController@show: Medical Record PDF found', ['ulid' => $ulid]);
        }

        return view('auth.medical-record.show', [
            'record' => $record,
            'patient' => $patient,
            'doctor' => $doctor,
            'opd' => $opd,
            'pdfPath' => $pdfPath,
        ]);
    }

    public function download(string $ulid)
    {
        $record = MedicalRecord::where('ulid', $ulid)->firstOrFail()->load('patient', 'doctor');
        $record_ulid = $record->ulid;
        $patient_ulid = $record->patient->ulid;
        $pdfPath = "storage/patients/{$patient_ulid}/medical-records/{$record_ulid}/{$record_ulid}.pdf";
        $savePath = "patients/{$patient_ulid}/medical-records/{$record_ulid}/{$record_ulid}.pdf";

        $pdf = public_path($pdfPath);

        if (!file_exists($pdf)) {
            Log::error('MedicalRecordController@download: PDF not found.', [
                'pdf' => $pdf,
                'medical_record_id' => $record->medical_record_id,
            ]);

            try {
                Pdf::view('pdfs.medical-record', ['record' => $record])
                    ->disk('public')
                    ->save($savePath);
            } catch (\Exception $e) {
                Log::error('MedicalRecordObserver@created: Error creating Medical Record: ' . $e->getMessage(), [
                    'medical_record_id' => $record->medical_record_id,
                ]);
            }
        }

        return response()->file($pdf, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename={$record_ulid}.pdf",
        ]);
    }
}
