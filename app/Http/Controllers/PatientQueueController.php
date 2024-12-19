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
     * Show the form for creating a new resource.
     */
    public function create(string $user_id)
    {
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
