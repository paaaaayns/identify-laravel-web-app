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
    public function index()
    {
        return view('auth.users.doctor.index');
    }

    public function create()
    {
        return view('auth.users.doctor.create');
    }

    public function validateStoreRequest(Request $request)
    {
        $validatedData = $request->validate([
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

            // Contact Information
            'address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->exists() || Doctor::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }],
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],

            // Emergency Contacts
            'room' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
            'license_number' => ['required', 'string', 'regex:/^[0-9]{7}$/', function ($attribute, $value, $fail) {
                if (Doctor::where('license_number', $value)->exists()) {
                    $fail('This license number is already taken.');
                }
            }],
        ], [
            'required' => 'This field is required',
            'accepted' => 'This field is required',

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

    public function store(Request $request)
    {
        $response = $this->validateStoreRequest($request)->getData(true);
        $data = $response['data'];


        $fieldsToCapitalize = [
            'first_name',
            'middle_name',
            'last_name',
            'religion',
            'citizenship',
            'address',
            'type',
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

        return response()->json([
            'success' => true,
            'message' => 'Doctor account created successfully.',
            'user' => $user,
        ], 200);
    }

    public function show(string $ulid)
    {
        $profile = Doctor::where('ulid', $ulid)->firstOrFail();

        return view('auth.users.doctor.show', [
            'profile' => $profile,
        ]);
    }

    public function destroy(string $user_id)
    {
        $user = Doctor::where('user_id', $user_id)->firstOrFail();
        $user->delete();
        $creds = User::where('user_id', $user_id)->firstOrFail();
        $creds->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
