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
            //
            'user_id' => fake()->name(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'type' => fake()->randomElement($doctorTypes),
        ];
    }
}
