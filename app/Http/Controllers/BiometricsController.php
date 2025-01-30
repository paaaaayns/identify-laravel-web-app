<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BiometricsController extends Controller
{
    /**
     * Store the biometric data.
     */
    public function store(Request $request)
    {
        Log::info('BiometricsController@store: Request received.', [
            'patient_ulid' => $request->patient_ulid,
        ]);

        try {
            // Validate the request
            $request->validate([
                'image' => 'required|string', // Base64-encoded string
            ]);

            // Get the patient ULID
            $ulid = $request->patient_ulid;

            // Decode the base64 image
            $imageData = $request->input('image');
            $imageData = explode(',', $imageData)[1]; // Remove the base64 header
            $imageData = base64_decode($imageData);


            // TODO: Iris Recognition Model Integration (saving the image to the public directory)
            // Save the image to the public directory using the ULID as the directory name
            // 3 images: face, left iris, right iris for display in patient profile
            // folder structure: 
            // face/profile_picture = /public/patients/{ulid}/biometrics/face.png
            // left_iris = /public/patients/{ulid}/biometrics/left_iris.png
            // right_iris = /public/patients/{ulid}/biometrics/right_iris.png


            // Generate a unique filename
            $directory = 'patients/' . $ulid . '/biometrics';
            $fileName = 'face.png';
            $filePath = "{$directory}/{$fileName}";

            // Store the image in the public directory
            $faceImagePath = Storage::disk('public')->put($filePath, $imageData);
            $leftIrisImagePath = Storage::disk('public')->put($filePath, $imageData);
            $rightIrisImagePath = Storage::disk('public')->put($filePath, $imageData);


            Log::info('Image stored successfully.', [
                'path' => Storage::url($filePath),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image stored successfully.',
                'faceImagePath' => Storage::url($filePath),
                'leftIrisImagePath' => Storage::url($filePath),
                'rightIrisImagePath' => Storage::url($filePath),

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error storing image: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search for a patient using biometric data.
     */
    public function search(Request $request)
    {
        Log::info('BiometricsController@search: Request received.', [
            'request' => $request,
        ]);

        try {
            // Validate the request
            $request->validate([
                'image' => 'required|string', // Base64-encoded string
            ]);

            // Decode the base64 image
            $imageData = $request->input('image');
            $imageData = explode(',', $imageData)[1]; // Remove the base64 header
            $imageData = base64_decode($imageData);

            // Iris Recognition Model Integration
            // TODO: Iris Recognition Model Integration (process biometric data)



            // Return the patient ULID
            return response()->json([
                'success' => true,
                'message' => 'Patient found.',
                'patient_ulid' => 'ULID1234567890',
            ]);

        } catch (\Exception $e) {
            Log::error('Error validating request.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error validating request: ' . $e->getMessage(),
            ], 400);
        }
    }
}
