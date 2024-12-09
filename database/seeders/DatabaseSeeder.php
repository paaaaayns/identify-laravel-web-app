<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(20)->create();
        
        
        // Call the AdminSeeder
        $this->call(AdminSeeder::class);

        // Call the DoctorSeeder
        $this->call(DoctorSeeder::class);

        // Call the OpdSeeder
        $this->call(OpdSeeder::class);

        // Seed doctor records
        Doctor::factory(5)->create();
        
        // Seed opd records
        Opd::factory(5)->create();

        // Seed patient records
        Patient::factory(5)->create();

        // Seed pre-registered patient records
        PreRegisteredPatient::factory(5)->create();

        // Seed user records
        // php artisan migrate:rollback && php artisan migrate:fresh --seed
    }
}
