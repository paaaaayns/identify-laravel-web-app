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
        //
        // dd($request->all());
        $opd_id = $request->input('opd_id');
        $patient_id = $request->input('patient_id');

        $queue = new PatientQueue();
        $queue->opd_id = $opd_id;
        $queue->patient_id = $patient_id;
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
        $queue = PatientQueue::where('ulid', $ulid)->first();
        // dd($queue->ulid);
        $patient = Patient::where('user_id', $queue->patient_id)->first();
        // dd($patient->user_id);

        return view('auth.queue.show', [
            'queue' => $queue,
            'patient' => $patient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ulid)
    {
        // Debugging to check received data
        // dd($request->all(), $ulid);

        // Validate the incoming request data (optional, but recommended)
        $validatedData = $request->validate([
            // Define validation rules for all possible fields
            'doctor_id' => 'nullable|exists:doctors,user_id',
            'vitals' => 'nullable|string',
            'other_field' => 'nullable|some_rule', // Add other fields as necessary
        ]);
        // dd($validatedData);

        // Fetch the queue based on the ulid
        $queue = PatientQueue::where('ulid', $ulid)->first();

        // Update only the fields present in the request
        $queue->update($validatedData);

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
