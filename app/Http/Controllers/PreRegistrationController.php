<?php

namespace App\Http\Controllers;

use App\Models\PreRegisteredPatient;
use App\Models\User;
use App\Rules\LettersAndSpaceOnly;
use Faker\Factory as Faker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PreRegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pre-register.create');
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
            'first_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'middle_name' => ['nullable', 'string', 'max:255', new LettersAndSpaceOnly()], // Allow middle name to be optional
            'last_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'birthdate' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) {
                // Convert to Carbon instance
                $date = Carbon::createFromFormat('Y-m-d', $value);

                // Check if the date is before today
                if ($date->isAfter(Carbon::today())) {
                    $fail('The birthdate must be before today.');
                }
            }], // Ensure birthdate is a valid date in the past
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'religion' => ['nullable', 'string', 'max:255', new LettersAndSpaceOnly()],
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
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
            'emergency_contact1_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'emergency_contact1_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"], // Validate phone number
            'emergency_contact1_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],
            'emergency_contact2_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()], // Second contact is optional
            'emergency_contact2_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact2_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],

            // Terms
            'terms_and_conditions' => ['accepted', 'required',], // 'accepted' ensures it's checked
            'privacy_policy' => ['accepted', 'required'], // 'accepted' ensures it's checked
        ], [
            'required' => 'This field is required', // Overrides all required fields
            'accepted' => 'This field is required', // Overrides all accepted fields

            'contact_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'contact_number.min' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact1_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact1_number.min' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact2_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'emergency_contact2_number.min' => 'Invalid contact number, Ex. 09123456789',
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

        // Exclude terms and data privacy policy from the validated data
        $validatedData = Arr::except($validatedData, ['terms_and_conditions', 'privacy_policy']);

        // Add additional fields not in validated data
        $validatedData['user_id'] = $code;
        $validatedData['pre_registration_code'] = $code;
        $validatedData['pre_registered_at'] = now();

        $user = new PreRegisteredPatient();
        $user->fill($validatedData);
        $user->save();

        // dd($user);

        session([
            'pre_registration_code' => $code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pre-registration successful.',
            'code' => $code,
        ], 201);
    }
}
