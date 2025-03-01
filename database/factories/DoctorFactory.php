<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doctorTypes = [
            'General Practitioner',
            'Cardiologist',
            'Dermatologist',
            'Endocrinologist',
            'Gastroenterologist',
            'Neurologist',
            'Oncologist',
            'Orthopedic Surgeon',
            'Pediatrician',
            'Psychiatrist',
        ];

        return [
            // Personal Information
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->lastName(),
            'last_name' => $this->faker->lastName(),
            'birthdate' => $this->faker->date(), // Date format: YYYY-MM-DD
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'religion' => $this->faker->randomElement(['Catholic', 'Buddhist', 'Muslim', 'Christian']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced']),
            'citizenship' => $this->faker->randomElement(['Filipino', 'American', 'Greek', 'Egyptian']),

            // Contact Details
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),

            'type' => fake()->randomElement($doctorTypes),
            'room' => $this->faker->regexify('[A-C][1-3][0-9]{2}'),
            'license_number' => $this->faker->unique()->regexify('[0-9]{7}'),
        ];
    }
}
