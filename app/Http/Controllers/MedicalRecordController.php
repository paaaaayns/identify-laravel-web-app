<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.medical-record.index');
    }

    /**
     * Display the specified resource.
     */
    public function apiShow($ulid)
    {
        // dd($ulid);
        Log::info('MedicalRecordController@apiShow: Medical Record API Show', ['ulid' => $ulid]);
        // return records, eager load patient, doctor, opd
        $record = MedicalRecord::query()
            ->where('ulid', $ulid)
            ->with(['patient', 'doctor', 'opd'])
            ->first();
        // dd($record);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Medical Record not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Medical Record retrieved successfully.',
            'data' => $record,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ulid)
    {
        // dd($ulid);
        $record = MedicalRecord::where('ulid', $ulid)->first();
        // dd($record);

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
        $record = MedicalRecord::where('ulid', $ulid)->firstOrFail();
        $patient = $record->patient;

        // Construct the actual file path
        $filePath = public_path("storage/patients/{$patient->ulid}/medical_records/{$record->ulid}/{$record->ulid}.pdf");

        // Check if the file exists
        if (!file_exists($filePath)) {
            Log::error('MedicalRecordController@download: Medical Record PDF not found', ['ulid' => $ulid]);
            return response()->json([
                'success' => false,
                'message' => 'File not found.'
            ], 404);
        }

        Log::info('MedicalRecordController@download: Medical Record PDF found', ['ulid' => $ulid]);

        // Return file as a download response
        return response()->download($filePath, "{$record->ulid}.pdf");
    }
}
