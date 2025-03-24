<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Rules\LettersAndSpaceOnly;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.users.doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('auth.users.doctor.create');
    }

    /**
     * Validate the store request.
     */
    public function validateStoreRequest(Request $request)
    {
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
            'sex' => ['required', Rule::in(['Male', 'Female']), new LettersAndSpaceOnly()],
            'religion' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],

            // Contact Information
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->exists() || Doctor::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }], // Validate email format
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"], // Validate phone number format (e.g., +123456789)

            // Emergency Contacts
            'room' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'license_number' => ['required', 'string', 'regex:/^[0-9]{7}$/', function ($attribute, $value, $fail) {
                if (Doctor::where('license_number', $value)->exists()) {
                    $fail('This license number is already taken.');
                }
            }],
        ], [
            'required' => 'This field is required', // Overrides all required fields
            'accepted' => 'This field is required', // Overrides all accepted fields

            'license_number.regex' => 'Invalid license number, Ex. 1234567',

            'email.email' => 'Invalid email address, Ex. 1234567',
            'contact_number.regex' => 'Invalid mobile number, Ex. 09123456789',
            'contact_number.min' => 'Invalid mobile number, Ex. 09123456789',
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

        
        $fieldsToCapitalize = [
            'first_name', 'middle_name', 'last_name', 'religion',
            'citizenship', 'address', 'type',
        ];
        foreach ($fieldsToCapitalize as $field) {
            if (isset($data[$field])) {
                $data[$field] = ucwords(strtolower($data[$field]));
            }
        }
        $data['email'] = strtolower($data['email']);

        $user = new Doctor();
        $user->fill($data);
        $user->save();
        // dd($user);

        return response()->json([
            'success' => true,
            'message' => 'Doctor account created successfully.',
            'user' => $user,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ulid)
    {
        // Fetch the user based on the ulid
        $profile = Doctor::where('ulid', $ulid)->firstOrFail();
        // dd($profile->ulid);

        return view('auth.users.doctor.show', [
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
        // dd($user_id);
        $user = Doctor::where('user_id', $user_id)->firstOrFail();
        $user->delete();
        $creds = User::where('user_id', $user_id)->firstOrFail();
        $creds->delete();
        // dd($user);

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
