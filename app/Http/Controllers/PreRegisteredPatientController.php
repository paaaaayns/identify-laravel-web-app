<?php

namespace App\Http\Controllers;

use App\Models\PreRegisteredPatient;
use App\Models\User;
use App\Rules\LettersAndSpaceOnly;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PreRegisteredPatientController extends Controller
{
    public function index()
    {
        return view('auth.users.pre-registered.index');
    }

    public function create()
    {
        return view('auth.users.pre-registered.create');
    }

    public function validateStoreRequest(Request $request)
    {
        $validatedData = $request->validate([
            // Personal Information
            'first_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'middle_name' => ['nullable', 'string', 'max:255', new LettersAndSpaceOnly()],
            'last_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'birthdate' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) {
                $date = Carbon::createFromFormat('Y-m-d', $value);

                if ($date->isAfter(Carbon::today())) {
                    $fail('The birthdate must be before today.');
                }
            }],
            'sex' => ['required', Rule::in(['Male', 'Female']), new LettersAndSpaceOnly()],
            'religion' => ['nullable', 'string', 'max:255', new LettersAndSpaceOnly()],
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'healthcard_number' => ['nullable', 'string', 'min:7'],

            // Contact Information
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->exists() || PreRegisteredPatient::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }],
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],

            // Emergency Contacts
            'emergency_contact1_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'emergency_contact1_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],
            'emergency_contact1_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact2_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'emergency_contact2_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],
            'emergency_contact2_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
        ], [
            'required' => 'This field is required',
            'accepted' => 'This field is required',

            'healthcard_number.min' => 'Invalid health card number, Ex. 1234567',
            'email.email' => 'Invalid email address, Ex. 1234567',

            'contact_number.regex' => 'Invalid mobile number, Ex. 09123456789',
            'contact_number.min' => 'Invalid mobile number, Ex. 09123456789',
            'emergency_contact1_number.regex' => 'Invalid mobile number, Ex. 09123456789',
            'emergency_contact1_number.min' => 'Invalid mobile number, Ex. 09123456789',
            'emergency_contact2_number.regex' => 'Invalid mobile number, Ex. 09123456789',
            'emergency_contact2_number.min' => 'Invalid mobile number, Ex. 09123456789',
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

        do {
            $faker = Faker::create();

            $code = $faker->regexify('[A-Z0-9]{8}');
        } while (PreRegisteredPatient::where('pre_registration_code', $code)->exists());

        $fieldsToCapitalize = [
            'first_name',
            'middle_name',
            'last_name',
            'religion',
            'citizenship',
            'address',
            'emergency_contact1_name',
            'emergency_contact1_relationship',
            'emergency_contact2_name',
            'emergency_contact2_relationship',
        ];
        foreach ($fieldsToCapitalize as $field) {
            if (isset($data[$field])) {
                $data[$field] = ucwords(strtolower($data[$field]));
            }
        }
        $data['email'] = strtolower($data['email']);

        $user = new PreRegisteredPatient();
        $user->fill($data);

        $user->user_id = $code;
        $user->pre_registration_code = $code;
        $user->pre_registered_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Patient pre-registered successfully.',
            'user' => $user,
        ], 200);
    }

    public function show(string $ulid)
    {
        $profile = PreRegisteredPatient::query()->where('ulid', $ulid)->firstOrFail();

        return view('auth.users.pre-registered.show', [
            'profile' => $profile,
        ]);
    }

    public function destroy(string $id)
    {
        $user = PreRegisteredPatient::where('user_id', $id)->first();
        $user->delete();
        $creds = User::where('user_id', $id)->first();
        if ($creds) {
            $creds->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
