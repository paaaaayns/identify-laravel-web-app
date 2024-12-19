<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreRegisteredPatient>
 */
class PreRegisteredPatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = $this->faker->regexify('[A-Z0-9]{8}');
        return [
            //
            // Personal Information
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->lastName(),
            'last_name' => $this->faker->lastName(),
            'birthdate' => $this->faker->date('Y-m-d', 'now'),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'religion' => $this->faker->randomElement(['Catholic', 'Buddhist', 'Muslim', 'Christian']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced']),
            'citizenship' => $this->faker->randomElement(['Filipino', 'American', 'Greek', 'Egyptian']),
            'healthcard_number' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{6}'), // Optional health card number

            // Contact Details
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->regexify('09[1-9][0-9]{8}'),

            // Emergency Contact 1
            'emergency_contact1_name' => $this->faker->name(),
            'emergency_contact1_number' => $this->faker->regexify('09[1-9][0-9]{8}'),
            'emergency_contact1_relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Friend', 'Spouse']),

            // Emergency Contact 2
            'emergency_contact2_name' => $this->faker->name(),
            'emergency_contact2_number' => $this->faker->regexify('09[1-9][0-9]{8}'),
            'emergency_contact2_relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Friend', 'Spouse']),

            // Pregistration Details
            'pre_registration_code' => $code,
            'user_id' => $code,
            'pre_registered_at' => now(),
        ];
    }
}
