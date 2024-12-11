<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Admin::create([
            'first_name' => 'Exiquiel John',
            'middle_name' => 'Aldave',
            'last_name' => 'Pines',
            'birthdate' => '2001-10-26',
            'sex' => 'Male',
            'religion' => 'Catholic',
            'civil_status' => 'Single',
            'citizenship' => 'Filipino',
            
            'address' => 'Mandaluyong City 1550 Metro Manila',
            'email' => 'admin@example.com',
            'contact_number' => '09955062741',
        ]);
    }
}
