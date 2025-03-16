<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Doctor::create([
            'first_name' => 'Test',
            'middle_name' => '',
            'last_name' => 'Doctor',
            'birthdate' => '2001-10-26',
            'sex' => 'Male',
            'religion' => 'Catholic',
            'civil_status' => 'Single',
            'citizenship' => 'Filipino',
            
            'address' => 'Mandaluyong City 1550 Metro Manila',
            'email' => 'doctor@example.com',
            'contact_number' => '09955062741',

            'type' => 'Neurologist',
            'room' => 'B101',
            'license_number' => '8025163',
        ]);
    }
}
