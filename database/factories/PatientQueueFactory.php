<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientQueueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'opd_id' => Opd::factory(),
            'doctor_id' => Doctor::factory(),
            'queue_status' => $this->faker->randomElement(['Waiting', 'Vitals Taken', 'Consulting', 'Completed', 'Cancelled']),
            'queued_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
        ];
    }
}
