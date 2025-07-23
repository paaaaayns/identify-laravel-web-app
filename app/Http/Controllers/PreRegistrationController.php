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
    public function create()
    {
        return view('pre-register.create');
    }

    public function store(Request $request)
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
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'religion' => ['nullable', 'string', 'max:255', new LettersAndSpaceOnly()],
            'civil_status' => ['required', Rule::in(['Single', 'Married', 'Divorced'])],
            'citizenship' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'healthcard_number' => ['nullable', 'string', 'max:50'],

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
            'emergency_contact1_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact1_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],
            'emergency_contact2_name' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'emergency_contact2_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],
            'emergency_contact2_relationship' => ['required', 'string', 'max:100', new LettersAndSpaceOnly()],

            // Terms
            'terms_and_conditions' => ['accepted', 'required',],
            'privacy_policy' => ['accepted', 'required'],
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
            if (isset($validatedData[$field])) {
                $validatedData[$field] = ucwords(strtolower($validatedData[$field]));
            }
        }
        $validatedData['email'] = strtolower($validatedData['email']);

        $validatedData = Arr::except($validatedData, ['terms_and_conditions', 'privacy_policy']);

        $validatedData['user_id'] = $code;
        $validatedData['pre_registration_code'] = $code;
        $validatedData['pre_registered_at'] = now();

        $user = new PreRegisteredPatient();
        $user->fill($validatedData);
        $user->save();

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
