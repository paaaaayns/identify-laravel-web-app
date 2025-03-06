<?php

namespace App\Http\Controllers;

use App\Models\IrisBiometrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class IrisBiometricsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required',
            'left_iris_image' => 'required',
            'right_iris_image' => 'required',
        ]);

        // make a post request to http://127.0.0.1:8000/store
        // $response = Http::post('http://127.0.0.1:8000/store', [
        //     'left_iris_image' => $validatedData['left_iris_image'],
        //     'right_iris_image' => $validatedData['right_iris_image'],
        // ]);

        // $response->validate([
        //     'left_iris_code' => 'required',
        //     'right_iris_code' => 'required',
        //     'left_iris_mask_code' => 'required',
        //     'right_iris_mask_code' => 'required',
        // ]);

        // store the response in the database
        // $irisBiometrics = new IrisBiometrics();
        // $irisBiometrics->ulid = Str::ulid();
        // $irisBiometrics->patient_id = $validatedData['patient_id'];
        // $irisBiometrics->left_iris_code = $response['left_iris_code'];
        // $irisBiometrics->right_iris_code = $response['right_iris_code'];
        // $irisBiometrics->left_iris_mask_code = $response['left_iris_mask_code'];
        // $irisBiometrics->right_iris_mask_code = $response['right_iris_mask_code'];
        // $irisBiometrics->save();

        $irisBiometrics = new IrisBiometrics();
        $irisBiometrics->ulid = Str::ulid();
        $irisBiometrics->patient_id = $validatedData['patient_id'];
        $irisBiometrics->left_iris_code = "test";
        $irisBiometrics->right_iris_code = "test";
        $irisBiometrics->left_iris_mask_code = "test";
        $irisBiometrics->right_iris_mask_code = "test";
        $irisBiometrics->save();

        return response()->json([
            'success' => true,
            'message' => 'Iris biometrics stored successfully.',
            'data' => $irisBiometrics,
        ], 200);
    }


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
