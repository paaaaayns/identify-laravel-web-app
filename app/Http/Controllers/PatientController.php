<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'left_iris' => ['required'], // Base64-encoded string
            'right_iris' => ['required'], // Base64-encoded string
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
        // remove the left_iris and right_iris from the data
        unset($data['left_iris']);
        unset($data['right_iris']);

        // log left_iris and right_iris
        Log::info('PatientController@store: Request received.', [
            'data' => $data,
        ]);
        





        try {
            $ulid = $request->ulid;

            $request->validate([
                'left_iris' => ['required', 'string', 'regex:/^data:image\/(jpeg|png|jpg|gif|svg);base64,/'], // Base64-encoded string
                'right_iris' => ['required', 'string', 'regex:/^data:image\/(jpeg|png|jpg|gif|svg);base64,/'], // Base64-encoded string
            ]);

            // Decode the base64 image
            $LeftImageData = $request->input('left_iris');
            $LeftImageData = explode(',', $LeftImageData)[1];
            $LeftImageData = base64_decode($LeftImageData);
            $RightImageData = $request->input('right_iris');
            $RightImageData = explode(',', $RightImageData)[1];
            $RightImageData = base64_decode($RightImageData);

            // Generate a unique filename
            $LeftImageDirectory = 'patients/' . $ulid . '/biometrics';
            $LeftImageFileName = 'left_iris.png';
            $LeftImageFilePath = "{$LeftImageDirectory}/{$LeftImageFileName}";
            $RightImageDirectory = 'patients/' . $ulid . '/biometrics';
            $RightImageFileName = 'right_iris.png';
            $RightImageFilePath = "{$RightImageDirectory}/{$RightImageFileName}";

            // Store the image in the public directory
            $LeftIrisImage = Storage::disk('public')->put($LeftImageFilePath, $LeftImageData);
            $RightIrisImage = Storage::disk('public')->put($RightImageFilePath, $RightImageData);

            Log::info('PatientController@store: Image stored successfully.', [
                'left_iris_image_path' => Storage::url($LeftImageFilePath),
                'right_iris_image_path' => Storage::url($RightImageFilePath),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error storing image: ' . $e->getMessage(),
            ], 500);
        }

        $user = new Patient();
        $user->fill(collect($request->all())->except('left_iris', 'right_iris')->toArray());

        // transfer old ulid to new ulid
        $user->ulid = $request->ulid;

        // add the pre_registration_code to the user
        $user->registered_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully.',
            'leftIrisImagePath' => Storage::url($LeftIrisImage),
            'rightIrisImagePath' => Storage::url($RightIrisImage),
            'user' => $user,
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
