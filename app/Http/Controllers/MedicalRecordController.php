<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

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
        // dd($request->all());
        $validatedData = $request->validate([
            'queue_id' => 'required|string|exists:queues,user_id',
            'opd_id' => 'required|string|exists:opds,user_id',
            'doctor_id' => 'required|string|exists:doctors,user_id',
            'patient_id' => 'required|string|exists:patients,user_id',

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

        // $medrec = new App\Models\MedicalRecord();
        // $validatedData = ['queue_id' => 'Q-20250108-DRAJ7', 'patient_id' => 'P-00001', 'opd_id' => 'O-00001', 'doctor_id' => 'D-00001'];
        // $medrec->fill($validatedData);
        // $medrec->save();

        $medical_record = new MedicalRecord();
        $medical_record->fill($validatedData);
        // dd($medical_record);

        // $medical_record->save();

        return response()->json([
            'success' => true,
            'message' => 'Medical Record created successfully.',
            'medical_record' => $medical_record,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
