<?php

namespace App\Http\Controllers;

use App\Models\IrisBiometrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class IrisBiometricsController extends Controller
{
    public function compare(Request $request)
    {
        $validatedData = $request->validate([
            'iris_image' => 'required',
        ]);

        $response = Http::post('http://127.0.0.1:8000/upload', [
            'iris_image' => $validatedData['iris_image'],
        ]);

        $response->validate([
            'iris_code' => 'required',
            'iris_mask_code' => 'required',
        ]);

        // iterate through the iris biometrics in the database
        // and compute the hamming distance
        // threshold is 0.32


        $irisBiometrics = IrisBiometrics::where('left_iris_code', $response['iris_code'])
            ->orWhere('right_iris_code', $response['iris_code'])
            ->orWhere('left_iris_mask_code', $response['iris_code'])
            ->orWhere('right_iris_mask_code', $response['iris_code'])
            ->first();


    }

    public function computeHammingDistance($code1, $code2)
    {
        $hammingDistance = 0;
        $code1 = str_split($code1);
        $code2 = str_split($code2);

        for ($i = 0; $i < count($code1); $i++) {
            if ($code1[$i] !== $code2[$i]) {
                $hammingDistance++;
            }
        }

        return $hammingDistance;
    }
}
