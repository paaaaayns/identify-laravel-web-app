<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientQueue>
 */
class PatientQueueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'patient_id' => Patient::factory(), // Creating a related patient using the Patient factory
            'opd_id' => Opd::factory(), // Creating a related patient using the Patient factory
            'doctor_id' => Doctor::factory(), // Creating a related patient using the Patient factory
            'queue_status' => $this->faker->randomElement(['Waiting', 'Vitals Taken', 'Consulting', 'Completed', 'Cancelled']),
            'queued_at' => $this->faker->dateTimeBetween('-1 day', 'now'), // A random time between the last 24 hours and now
        ];
    }
}
