<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        try {
            $validatedData = $request->validate([
                'opd_id' => 'required|string|exists:opds,user_id',
                'doctor_id' => 'nullable|string|exists:doctors,user_id',
                'patient_id' => 'required|string|exists:patients,user_id',
            ]);

            $queue = new PatientQueue();
            $queue->fill($validatedData);
            $queue->save();

            return response()->json([
                'success' => true,
                'message' => 'Queue created successfully.',
                'queue' => $queue,
            ], 200);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('PatientQueueController@store: Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);

            // Return a response to the client with validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('PatientQueueController@store: An unexpected error occurred', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            // Return a generic error response
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
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

        Log::info('PatientQueueController@update: Queue update request', [
            'request_data' => $request->all(),
            'ulid' => $ulid,
        ]);
        try {
            $validatedData = $request->validate([
                'queue_status' => 'string|nullable',

                // Doctor Selection
                'doctor_id' => 'exists:doctors,user_id|nullable',

                // Assessment
                'primary_complaint' => 'string|nullable',
                'duration_of_symptoms' => 'string|nullable',
                'intensity_and_frequency' => 'string|nullable',
                'height' => 'string|nullable',
                'weight' => 'string|nullable',
                'blood_pressure' => 'string|nullable',
                'temperature' => 'string|nullable',
                'pulse_rate' => 'string|nullable',
                'respiration_rate' => 'string|nullable',
                'o2_sat' => 'string|nullable',
                'other' => 'string|nullable|nullable',

                'assessment_done_at' => 'date|nullable',

                // Consultation
                'findings' => 'string|nullable',
                'diagnosis' => 'string|nullable',
                'recommended_treatment' => 'string|nullable',
                'follow_up_instructions' => 'string|nullable',
                'referrals' => 'string|nullable',
                'doctor_notes' => 'string|nullable',

                'consultation_done_at' => 'date|nullable',
            ]);

            // Safely check and set timestamps based on queue_status
            $queueStatus = $validatedData['queue_status'] ?? null;

            if ($queueStatus === 'Assessment Done') {
                $validatedData['assessment_done_at'] = now();
            } elseif ($queueStatus === 'Completed') {
                $validatedData['consultation_done_at'] = now();
            }

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
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('PatientQueueController@update: Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);

            // Return a response to the client with validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log any unexpected errors
            Log::error('PatientQueueController@update: Unexpected error occurred', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            // Return a generic error response
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update Assessment
     */
    public function updateAssessment(Request $request, string $ulid)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ulid)
    {
        // dd($ulid);
        $queue = PatientQueue::where('ulid', $ulid)->firstOrFail();
        // set the queue status to 'Cancelled'
        $queue->queue_status = 'Cancelled';
        $queue->save();

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
