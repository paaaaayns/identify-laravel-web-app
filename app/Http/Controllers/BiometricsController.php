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
            'request' => $request->patient,
        ]);

        try {
            // Validate the request
            $request->validate([
                'image' => 'required|string', // Base64-encoded string
            ]);

            // Get the patient ULID
            $ulid = $request->patient;

            // Decode the base64 image
            $imageData = $request->input('image');
            $imageData = explode(',', $imageData)[1]; // Remove the base64 header
            $imageData = base64_decode($imageData);


            // TODO: Iris Recognition Model Integration
            // Save the image to the public directory using the ULID as the directory name
            // 3 images: face, left iris, right iris for display in patient profile


            // Generate a unique filename
            $directory = $ulid . '/biometrics';
            $fileName = 'face.png';
            $filePath = "{$directory}/{$fileName}";

            // Store the image in the public directory
            $path = Storage::disk('public')->put($filePath, $imageData);

            Log::info('Image stored successfully.', [
                'path' => Storage::url($path),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image stored successfully.',
                'path' => Storage::url($path),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error storing image: ' . $e->getMessage(),
            ], 500);
        }
    }
}
