<?php

namespace App\Observers;

use App\Models\PreRegisteredPatient;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PatientPreRegistrationObserver
{
    //
    public function creating(PreRegisteredPatient $patient)
    {
        // The ID is not available here yet, so we don't need to generate user_id during the "creating" phase.
    }

    public function created(PreRegisteredPatient $patient)
    {
        // // Generate a unique 8-character pre_registration_code consisting of uppercase letters and numbers.
        // do {
        //     // Create a new Faker instance
        //     $faker = Faker::create();

        //     // Use regexify to generate an 8-character alphanumeric code (uppercase letters and numbers)
        //     $code = $faker->regexify('[A-Z0-9]{8}');
        // } while (PreRegisteredPatient::where('pre_registration_code', $code)->exists()); // Ensure uniqueness by checking if the pre_registration_code already exists

        // // Assign the generated pre_registration_code
        // $patient->pre_registration_code = $code;

        // // Save the patient without triggering further events
        // $patient->saveQuietly();
    }
}