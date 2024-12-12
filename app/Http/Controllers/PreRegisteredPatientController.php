<?php

namespace App\Http\Controllers;

use App\Models\PreRegisteredPatient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PreRegisteredPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.users.pre-registered.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('auth.users.pre-registered.create');
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
                if (User::where('email', $value)->exists() || PreRegisteredPatient::where('email', $value)->exists()) {
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
        $data = $response['data']; // Access the 'data' key from the array

        // Generate a unique 8-character pre_registration_code consisting of uppercase letters and numbers.
        do {
            // Create a new Faker instance
            $faker = Faker::create();

            // Use regexify to generate an 8-character alphanumeric code (uppercase letters and numbers)
            $code = $faker->regexify('[A-Z0-9]{8}');
        } while (PreRegisteredPatient::where('pre_registration_code', $code)->exists()); // Ensure uniqueness by checking if the pre_registration_code already exists
        // dd($code);

        $user = new PreRegisteredPatient();
        $user->fill($data);

        // add the pre_registration_code to the user
        $user->user_id = $code;
        $user->pre_registration_code = $code;
        $user->pre_registered_at = now();
        $user->save();
        // dd($user);

        return response()->json([
            'success' => true,
            'message' => 'Patient pre-registered successfully.',
            'user' => $user,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        // Fetch the user based on the user_id
        $profile = PreRegisteredPatient::where('pre_registration_code', $user_id)->first();
        // dd($profile->user_id);

        return view('auth.users.pre-registered.show', [
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
    public function destroy(string $id)
    {
        $user = PreRegisteredPatient::where('user_id', $id)->first();
        $user->delete();
        $creds = User::where('user_id', $id)->first();
        if ($creds) {
            $creds->delete();
        }
        // dd($user);

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
