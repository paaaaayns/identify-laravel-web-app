<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use App\Rules\LettersAndSpaceOnly;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class OpdController extends Controller
{
    public function index()
    {
        return view('auth.users.opd.index');
    }

    public function create()
    {
        return view('auth.users.opd.create');
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
                if (User::where('email', $value)->exists() || Opd::where('email', $value)->exists()) {
                    $fail('This email is already taken.');
                }
            }],
            'contact_number' => ['required', 'regex:/^09[0-9]{7,13}$/', "min:11"],

            // Department Information
            'type' => ['required', 'string', 'max:255', new LettersAndSpaceOnly()],
        ], [
            'required' => 'This field is required',
            'accepted' => 'This field is required',

            'email.email' => 'Invalid email address, Ex. 1234567',
            'contact_number.regex' => 'Invalid contact number, Ex. 09123456789',
            'contact_number.min' => 'Invalid contact number, Ex. 09123456789',
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

        $user = new Opd();
        $user->fill($data);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'OPD account created successfully.',
            'user' => $user,
        ], 200);
    }

    public function show(string $ulid)
    {
        $profile = Opd::where('ulid', $ulid)->firstOrFail();

        return view('auth.users.opd.show', [
            'profile' => $profile,
        ]);
    }

    public function destroy(string $user_id)
    {
        $user = Opd::where('user_id', $user_id)->firstOrFail();
        $user->delete();
        $creds = User::where('user_id', $user_id)->firstOrFail();
        $creds->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record successfully deleted.'
        ], 200);
    }
}
