<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        Log::info('PatientQueueController@update: Queue update request', [
            'ulid' => $ulid,
            'request_data' => $request->all(),
        ]);
        try {
            $validatedData = $request->validate([
                'queue_action' => 'string|nullable',

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
                'attachments' => 'array|nullable',

                'consultation_done_at' => 'date|nullable',
            ]);

            $attachments = $validatedData['attachments'] ?? null;
            unset($validatedData['attachments']);

            if ($attachments) {
                Log::info('PatientQueueController@update: Attachments', [
                    'count' => count($attachments),
                    'attachments' => $attachments,
                ]);

                $record = PatientQueue::where('ulid', $ulid)->firstOrFail();
                $patient_ulid = $record->patient->ulid;
                $record_ulid = $record->ulid;

                // save the attachments
                if ($attachments) {
                    foreach ($attachments as $attachment) {
                        Storage::disk('public')->put("patients/{$patient_ulid}/medical-records/{$record_ulid}/attachments/{$attachment->getClientOriginalName()}", $attachment->get());
                        Log::info('PatientQueueController@update: Attachment saved', [
                            'path' => $attachment->getClientOriginalName(),
                        ]);
                    }
                }
            }


            // Safely check and set timestamps based on queue_status
            $queue_action = $validatedData['queue_action'] ?? null;
            Log::info('PatientQueueController@update: queue_Action', [
                'queue_action' => $queue_action,
            ]);

            switch ($queue_action) {
                case 'Doctor Assigned':
                    $validatedData['queue_status'] = 'Awaiting Assessment';
                    $validatedData['doctor_selected_at'] = now();
                    break;

                case 'Start Assessment':
                    $validatedData['queue_status'] = 'Assessing';
                    $validatedData['assessment_started_at'] = now();
                    break;

                case 'Assessment Done':
                    $validatedData['queue_status'] = 'Awaiting Consultation';
                    $validatedData['assessment_done_at'] = now();
                    break;

                case 'Start Consultation':
                    $validatedData['queue_status'] = 'Consulting';
                    $validatedData['consultation_started_at'] = now();
                    break;

                case 'Consultation Done':
                    $validatedData['queue_status'] = 'Completed';
                    $validatedData['consultation_done_at'] = now();
                    break;
            }

            unset($validatedData['queue_action']);

            Log::info('PatientQueueController@update: Validated data', [
                'validatedData' => $validatedData,
            ]);

            // Fetch the queue based on the ulid
            $queue = PatientQueue::where('ulid', $ulid)->first();


            // Update only the fields present in the request
            $queue->update($validatedData);
            // dd($queue->doctor_id);

            return response()->json([
                'success' => true,
                'message' => 'Queue updated successfully.',
                'queue' => $queue,
                'isConsultationDone' => $queue->queue_status === 'Completed',
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
