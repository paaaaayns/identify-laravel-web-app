<?php

namespace App\Http\Controllers;

use App\Models\IrisBiometrics;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.users.patient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Validate the store request.
     */
    public function validateStoreRequest(Request $request)
    {
        $validatedData = $request->validate([
            // Personal Information
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'], // Allow middle name to be optional
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) {
                // Convert to Carbon instance
                $date = Carbon::createFromFormat('Y-m-d', $value);

                // Check if the date is before today
                if ($date->isAfter(Carbon::today())) {
                    $fail('The birthdate must be before today.');
                }
            }], // Ensure birthdate is a valid date in the past
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'religion' => ['required', 'string', 'max:255'], // Optional but validated if present
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255'],
            'healthcard_number' => ['nullable', 'string', 'max:50'], // Assuming healthcard_number is alphanumeric

            // Contact Information
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }], // Validate email format
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"], // Validate phone number format (e.g., +123456789)

            // Emergency Contacts
            'emergency_contact1_name' => ['required', 'string', 'max:255'],
            'emergency_contact1_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"], // Validate phone number
            'emergency_contact1_relationship' => ['required', 'string', 'max:100'],
            'emergency_contact2_name' => ['required', 'string', 'max:255'], // Second contact is optional
            'emergency_contact2_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact2_relationship' => ['required', 'string', 'max:100'],

            // Biometrics
            'left_iris' => ['required', 'image', 'mimes:bmp', 'max:2048'], // Base64-encoded string
            'right_iris' => ['required', 'image', 'mimes:bmp', 'max:2048'], // Base64-encoded string
        ], [
            'required' => 'This field is required', // Overrides all required fields
            'accepted' => 'This field is required', // Overrides all accepted fields

            'contact_number.regex' => 'Invalid contact number',
            'contact_number.min' => 'Invalid contact number',
            'emergency_contact1_number.regex' => 'Invalid contact number',
            'emergency_contact1_number.min' => 'Invalid contact number',
            'emergency_contact2_number.regex' => 'Invalid contact number',
            'emergency_contact2_number.min' => 'Invalid contact number',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store request validated successfully.',
            'data' => $validatedData,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request and get validated data
        $response = $this->validateStoreRequest($request)->getData(true); // Use 'true' to get an associative array
        $data = $response['data'];

        // log the request
        Log::info('PatientController@store: Request received.', []);


        $leftIrisImage = $request->file('left_iris');
        $rightIrisImage = $request->file('right_iris');

        $patient_ulid = $request->ulid;

        Log::info('PatientController@store: Image mimetype:', [
            'left_iris' => $leftIrisImage->getMimeType(),
            'right_iris' => $rightIrisImage->getMimeType(),
        ]);

        try {
            $response = Http::asMultipart()
                ->attach('left_iris', file_get_contents($leftIrisImage), 'left_iris.bmp')
                ->attach('right_iris', file_get_contents($rightIrisImage), 'right_iris.bmp')
                ->post('http://127.0.0.1:8000/fast-api/store', []);

            $responseData = $response->json();

            if ($responseData['success'] === true) {
                Log::info('PatientObserver@creating: Iris biometrics processed successfully.', [
                    'response' => $responseData,
                ]);
            } else {
                throw new \Exception("API Error: " . ($responseData['message'] ?? 'Unknown error'));
            }

            $leftIrisBiometrics = new IrisBiometrics();
            $leftIrisBiometrics->ulid = Str::ulid();
            $leftIrisBiometrics->patient_ulid = $patient_ulid;
            $leftIrisBiometrics->orientation = "left";
            $leftIrisBiometrics->iris_code = gzdecode(base64_decode($responseData["data"]["left_iris_code"]));
            $leftIrisBiometrics->mask_code = gzdecode(base64_decode($responseData["data"]["left_mask_code"]));

            $rightIrisBiometrics = new IrisBiometrics();
            $rightIrisBiometrics->ulid = Str::ulid();
            $rightIrisBiometrics->patient_ulid = $patient_ulid;
            $rightIrisBiometrics->orientation = "right";
            $rightIrisBiometrics->iris_code = gzdecode(base64_decode($responseData["data"]["right_iris_code"]));
            $rightIrisBiometrics->mask_code = gzdecode(base64_decode($responseData["data"]["right_mask_code"]));
        } catch (\Exception $e) {
            Log::error('PatientObserver@creating: Error storing iris biometrics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error making FastAPI request: ' . $e->getMessage(),
            ], 500);
        }

        $patient = new Patient();
        $patient->fill(collect($request->all())->except('left_iris', 'right_iris')->toArray());

        // transfer old ulid to new ulid
        $patient->ulid = $patient_ulid;

        // add the pre_registration_code to the patient
        $patient->registered_at = now();


        try {
            $patient->save();
            $leftIrisBiometrics->save();
            $rightIrisBiometrics->save();
            $leftIrisImageFilePath = "patients/{$patient_ulid}/biometrics/left_iris." . $leftIrisImage->getClientOriginalExtension();
            $rightIrisImageFilePath = "patients/{$patient_ulid}/biometrics/right_iris." . $rightIrisImage->getClientOriginalExtension();
            Storage::disk('public')->put($leftIrisImageFilePath, file_get_contents($leftIrisImage->getRealPath()));
            Storage::disk('public')->put($rightIrisImageFilePath, file_get_contents($rightIrisImage->getRealPath()));
        } catch (\Exception $e) {
            Log::error('PatientController@store: Error storing patient record.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error storing patient record.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully.',
            'user' => $patient,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ulid)
    {
        // Fetch the user based on the ulid
        $profile = Patient::where('ulid', $ulid)->firstOrFail();
        // dd($profile->ulid);

        return view('auth.users.patient.show', [
            'profile' => $profile,
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
    public function destroy(string $user_id)
    {
        $user = Patient::where('user_id', $user_id)->firstOrFail();
        $user->delete();
        $creds = User::where('user_id', $user_id)->firstOrFail();
        $creds->delete();

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
