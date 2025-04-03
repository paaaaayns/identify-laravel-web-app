<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OpdFactory extends Factory
{
    public function definition(): array
    {
        $opdDepartments = [
            'General Medicine',
            'Orthopedics',
            'Pediatrics',
            'Dermatology',
            'ENT (Ear, Nose, Throat)',
            'Ophthalmology',
            'Cardiology',
            'Gynecology',
            'Neurology',
            'Psychiatry',
        ];

        return [
            // Personal Information
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->lastName(),
            'last_name' => $this->faker->lastName(),
            'birthdate' => $this->faker->date(),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'religion' => $this->faker->randomElement(['Catholic', 'Buddhist', 'Muslim', 'Christian']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced']),
            'citizenship' => $this->faker->randomElement(['Filipino', 'American', 'Greek', 'Egyptian']),

            // Contact Details
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),

            // Additional Fields
            'type' => fake()->randomElement($opdDepartments),
        ];
    }
}
