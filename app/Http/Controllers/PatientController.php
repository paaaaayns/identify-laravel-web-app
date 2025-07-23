<?php

namespace App\Http\Controllers;

use App\Models\IrisBiometrics;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use App\Rules\ValidIrisImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index()
    {
        return view('auth.users.patient.index');
    }

    public function validateStoreRequest(Request $request)
    {
        $validatedData = $request->validate([
            // Personal Information
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) {
                $date = Carbon::createFromFormat('Y-m-d', $value);

                if ($date->isAfter(Carbon::today())) {
                    $fail('The birthdate must be before today.');
                }
            }],
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'religion' => ['nullable', 'string', 'max:255'],
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255'],
            'healthcard_number' => ['nullable', 'string', 'max:50'],

            // Contact Information
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }],
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],

            // Emergency Contacts
            'emergency_contact1_name' => ['required', 'string', 'max:255'],
            'emergency_contact1_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact1_relationship' => ['required', 'string', 'max:100'],
            'emergency_contact2_name' => ['required', 'string', 'max:255'],
            'emergency_contact2_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact2_relationship' => ['required', 'string', 'max:100'],

            // Biometrics
            'left_iris' => ['required', new ValidIrisImage()],
            'right_iris' => ['required', new ValidIrisImage()],
        ], [
            'required' => 'This field is required',
            'accepted' => 'This field is required',

            'contact_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'contact_number.min' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact1_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact1_number.min' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact2_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact2_number.min' => 'Invalid contact number, Ex. 09123456789',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store request validated successfully.',
            'data' => $validatedData,
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->validateStoreRequest($request)->getData(true);
        $data = $response['data'];

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

            if (! $responseData['success']) {
                throw new \Exception("API Error: " . ($responseData['message'] ?? 'Unknown error'));
            }

            Log::info('PatientController@store: Iris biometrics processed successfully.');

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
            Log::error('PatientController@store: Error storing iris biometrics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error making FastAPI request: ' . $e->getMessage(),
            ], 500);
        }

        $patient = new Patient();
        $patient->fill(collect($request->all())->except('left_iris', 'right_iris')->toArray());
        $patient->ulid = $patient_ulid;
        $patient->registered_at = now();

        try {
            DB::transaction(function () use ($patient, $leftIrisBiometrics, $rightIrisBiometrics, $patient_ulid, $leftIrisImage, $rightIrisImage) {
                $patient->save();
                $leftIrisBiometrics->save();
                $rightIrisBiometrics->save();

                $leftIrisImageFilePath = "patients/{$patient_ulid}/biometrics/left_iris." . $leftIrisImage->getClientOriginalExtension();
                $rightIrisImageFilePath = "patients/{$patient_ulid}/biometrics/right_iris." . $rightIrisImage->getClientOriginalExtension();
                Storage::disk('public')->put($leftIrisImageFilePath, file_get_contents($leftIrisImage->getRealPath()));
                Storage::disk('public')->put($rightIrisImageFilePath, file_get_contents($rightIrisImage->getRealPath()));
            });
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

    public function show(string $ulid)
    {
        $patient = Patient::where('ulid', $ulid)->firstOrFail();

        return view('auth.users.patient.show', [
            'patient' => $patient,
        ]);
    }

    public function destroy(string $user_id)
    {
        $user = Patient::where('user_id', $user_id)->firstOrFail();
        $creds = User::where('user_id', $user_id)->firstOrFail();

        DB::transaction(function () use ($user, $creds) {
            $user->delete();
            $creds->delete();
            $user->irisBiometrics()->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
