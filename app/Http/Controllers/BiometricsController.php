<?php

namespace App\Http\Controllers;

use App\Models\IrisBiometrics;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BiometricsController extends Controller
{
    /**
     * Search for a patient using biometric data.
     */
    public function search(Request $request)
    {
        $request->validate([
            'iris' => 'required|image|mimes:bmp|max:2048',
        ]);

        $imageData = $request->file('iris');
        $imagePath = 'search/iris.bmp';

        try {
            Storage::disk('public')->put($imagePath, file_get_contents($imageData->getRealPath()));
        } catch (\Exception $e) {
            Log::error('Failed to store uploaded image.', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to store uploaded image.',
            ], 500);
        }

        $imagePath = public_path("storage/{$imagePath}");
        if (!file_exists($imagePath)) {
            Log::error('BiometricsController@search: Image does not exist.', [
                'image_path' => $imagePath,
            ]);
        }

        try {
            $irisBiometrics = IrisBiometrics::all()->map(function ($iris) {
                return [
                    'patient_ulid' => $iris->patient_ulid,
                    'iris_code' => base64_encode(gzencode($iris->iris_code)),
                    'mask_code' => base64_encode(gzencode($iris->mask_code)),
                ];
            });

            $response = Http::asMultipart()
                ->attach('iris', file_get_contents($imageData), 'iris.bmp')
                ->post('http://127.0.0.1:8000/fast-api/search', [
                    'stored_irises' => json_encode($irisBiometrics),
                ]);

            $responseData = $response->json();

            if ($responseData['success'] === true) {
                $ulid = $responseData['data']['patient_ulid'];

                $patient = Patient::where('ulid', $ulid)->first();

                if ($patient) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Patient found.',
                        'data' => [
                            'patient' => $patient,
                        ],
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Patient not found.',
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found.',
                ], 404);
            }
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
