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
        $breadcrumbs = [
            [
                'label' => 'Users',
                'url' => route('dashboard'),
            ],
            [
                'label' => 'Pre-Registered Patients',
                'url' => route('dashboard', ['project' => 1]),  // Example route with dynamic parameter
                'current' => true,  // Mark the current page
            ]
        ];
        return view('pre-reg.index', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pre-reg.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd(request());

        $validatedData = $request->validate([
            // Personal Information
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'], // Allow middle name to be optional
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date_format:m-d-Y', function ($attribute, $value, $fail) {
                // Convert to Carbon instance
                $date = Carbon::createFromFormat('m-d-Y', $value);

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

            // Terms
            'terms_and_conditions' => ['accepted', 'required',], // 'accepted' ensures it's checked
            'privacy_policy' => ['accepted', 'required'], // 'accepted' ensures it's checked
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

        // dd($validatedData);

        // Generate a unique 8-character pre_registration_code consisting of uppercase letters and numbers.
        do {
            // Create a new Faker instance
            $faker = Faker::create();

            // Use regexify to generate an 8-character alphanumeric code (uppercase letters and numbers)
            $code = $faker->regexify('[A-Z0-9]{8}');
        } while (PreRegisteredPatient::where('pre_registration_code', $code)->exists()); // Ensure uniqueness by checking if the pre_registration_code already exists

        // dd($code);

        // Exclude terms and privacy policy from the validated data
        $validatedData = Arr::except($validatedData, ['terms_and_conditions', 'privacy_policy']);

        // Adjust birthdate format in the filtered data
        $validatedData['birthdate'] = Carbon::createFromFormat('m-d-Y', $validatedData['birthdate'])->format('Y-m-d');

        // Add additional fields not in validated data
        $validatedData['pre_registration_code'] = $code;
        $validatedData['pre_registered_at'] = now();

        $patient = new PreRegisteredPatient();
        $patient->fill($validatedData);
        $patient->save();

        // dd($patient);

        session([
            'pre_registration_code' => $code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pre-registration successful.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        // Fetch the user based on the user_id
        $user = PreRegisteredPatient::where('pre_registration_code', $user_id)->first();
        // dd($user);

        return view('pre-reg.show', [
            'user' => $user,
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
        // dd($id);

        $user = PreRegisteredPatient::where('pre_registration_code', $id)->firstOrFail();
        $user->delete();
        $creds = User::where('user_id', $id)->first();
        $creds->delete();
        // dd($user);

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
