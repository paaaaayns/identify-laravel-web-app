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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function apiShow($ulid)
    {
        // dd($ulid);
        Log::info('Medical Record API Show', ['ulid' => $ulid]);
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

        return view('auth.medical-record.show', [
            'record' => $record,
            'patient' => $patient,
            'doctor' => $doctor,
            'opd' => $opd,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ulid)
    {
        //
        // dd($request->all());
        $validatedData = $request->validate([
            // Doctor Selection
            'doctor_id' => 'exists:doctors,user_id',

            // Patient Vitals
            'height' => 'string',
            'weight' => 'string',
            'blood_pressure' => 'string',
            'temperature' => 'string',
            'pulse_rate' => 'string',
            'respiration_rate' => 'string',
            'o2_sat' => 'string',
            'other' => 'string',

            // Findings
            'primary_complaint' => 'string',
            'duration_of_symptoms' => 'string',
            'intensity_and_frequency' => 'string',

            'findings' => 'string',
            'diagnosis' => 'string',
            'recommended_treatment' => 'string',
            'follow_up_instructions' => 'string',
            'referrals' => 'string',

            'doctor_notes' => 'string',
        ]);
        dd($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
