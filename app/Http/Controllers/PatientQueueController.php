<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Http\Request;

class PatientQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.queue.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'opd_id' => 'required|string|exists:opds,user_id',
            'patient_id' => 'required|string|exists:patients,user_id',
        ]);
        // dd($validatedData);

        $queue = new PatientQueue();
        $queue->fill($validatedData);
        // dd($queue);

        $queue->save();

        return response()->json([
            'success' => true,
            'message' => 'Queue created successfully.',
            'queue' => $queue,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ulid)
    {
        // Fetch the queue based on the ulid
        $queue = PatientQueue::with(['patient', 'opd', 'doctor'])->where('ulid', $ulid)->first();
        // dd($queue);

        $patient = $queue->patient;
        $opd = $queue->opd;
        $doctor = $queue->doctor;
        // $patient = Patient::where('user_id', $queue->patient_id)->first();

        return view('auth.queue.show', [
            'queue' => $queue,
            'patient' => $patient,
            'opd' => $opd,
            'doctor' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ulid)
    {
        // dd($request->all(), $ulid);

        // Validate the incoming request data (optional, but recommended)
        $validatedData = $request->validate([
            'queue_status' => 'string',

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
        // dd($validatedData);

        // Fetch the queue based on the ulid
        $queue = PatientQueue::where('ulid', $ulid)->first();
        // dd($queue->ulid);

        // Update only the fields present in the request
        $queue->update($validatedData);
        // dd($queue->doctor_id);

        return response()->json([
            'success' => true,
            'message' => 'Queue updated successfully.',
            'queue' => $queue,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
