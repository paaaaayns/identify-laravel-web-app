<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opd>
 */
class OpdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

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
            //
            'user_id' => fake()->name(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'type' => fake()->randomElement($opdDepartments),
        ];
    }
}
