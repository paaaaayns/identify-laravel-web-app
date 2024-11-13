<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Opd;
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

        // Seed 10 doctor records
        Doctor::factory(10)->create();

        
        // Seed 10 opd records
        Opd::factory(10)->create();
    }
}
