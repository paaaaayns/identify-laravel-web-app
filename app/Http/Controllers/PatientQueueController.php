<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\PatientQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PatientQueueController extends Controller
{
    public function index()
    {
        return view('auth.queue.index');
    }

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
            Log::error('PatientQueueController@store: Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('PatientQueueController@store: An unexpected error occurred', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function show(string $ulid)
    {
        $queue = PatientQueue::with(['patient', 'opd', 'doctor'])->where('ulid', $ulid)->first();

        $patient = $queue->patient;
        $opd = $queue->opd;
        $doctor = $queue->doctor;

        return view('auth.queue.show', [
            'queue' => $queue,
            'patient' => $patient,
            'opd' => $opd,
            'doctor' => $doctor,
        ]);
    }

    public function update(Request $request, string $ulid)
    {
        Log::info('PatientQueueController@update: Queue update request', [
            'ulid' => $ulid,
            'request_data' => $request->all(),
        ]);
        try {
            $validatedData = $request->validate([
                'queue_action' => 'string|nullable',

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

                if ($attachments) {
                    foreach ($attachments as $attachment) {
                        Storage::disk('public')->put("patients/{$patient_ulid}/medical-records/{$record_ulid}/attachments/{$attachment->getClientOriginalName()}", $attachment->get());
                        Log::info('PatientQueueController@update: Attachment saved', [
                            'path' => $attachment->getClientOriginalName(),
                        ]);
                    }
                }
            }

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

            $queue = PatientQueue::where('ulid', $ulid)->first();

            $queue->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Queue updated successfully.',
                'queue' => $queue,
                'isConsultationDone' => $queue->queue_status === 'Completed',
            ], 200);
        } catch (ValidationException $e) {
            Log::error('PatientQueueController@update: Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('PatientQueueController@update: Unexpected error occurred', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function destroy(string $ulid)
    {
        $queue = PatientQueue::where('ulid', $ulid)->firstOrFail();
        $queue->queue_status = 'Cancelled';
        $queue->save();

        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
