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
            'first_name' => 'Exiquiel John',
            'middle_name' => 'Aldave',
            'last_name' => 'Pines',
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
