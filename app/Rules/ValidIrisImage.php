<?php

namespace App\Rules;

use App\Models\IrisBiometrics;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ValidIrisImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $attribute = str_replace('_', ' ', $attribute);

        // Check if the value is a file
        if (!$value || !is_file($value->getRealPath())) {
            $fail("The {$attribute} is not a valid image file.");
            Log::info("ValidIrisImage@validate: {$attribute} is not a valid image file.", [
                'value' => $value->getRealPath(),
            ]);
            return;
        }

        // Check the MIME type manually
        $mimeType = $value->getMimeType();
        if (!str_starts_with($mimeType, 'image/')) {
            $fail("The {$attribute} must be an image file.");
            Log::info("ValidIrisImage@validate: {$attribute} is not an image file.", [
                'mimeType' => $mimeType,
            ]);
            return;
        }

        // Check if the image is a BMP image
        if ($mimeType !== 'image/bmp') {
            $fail("The {$attribute} must be a BMP image.");
            Log::info("ValidIrisImage@validate: {$attribute} is not a BMP image.", [
                'mimeType' => $mimeType,
            ]);
            return;
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
                ->attach('iris', file_get_contents($value), 'left_iris.bmp')
                ->post('http://127.0.0.1:8000/fast-api/search', [
                    'stored_irises' => json_encode($irisBiometrics),
                ]);

            $responseData = $response->json();

            if ($responseData['success'] === false) {
                Log::info("ValidIrisImage@validate: {$attribute} has no match. Clear to proceed.", [
                    'response' => $responseData,
                ]);
            } else {
                Log::info("ValidIrisImage@validate: {$attribute} has a match.", [
                    'response' => $responseData,
                ]);

                $fail("The {$attribute} has a match.");
                return;
                throw new \Exception("API Error: " . ($responseData['message'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            $fail("The {$attribute} is not a valid iris image.");
            return;
        }
    }
}
