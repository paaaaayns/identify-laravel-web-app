<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        
        // Call the UserSeeder
        $this->call(UserSeeder::class);

        // Seed doctor records
        Doctor::factory(3)->create();

        
        // Seed opd records
        Opd::factory(3)->create();

        // Seed patient records
        Patient::factory(3)->create();
    }
}
