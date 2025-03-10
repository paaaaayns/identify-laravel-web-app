<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\PreRegisteredPatient;
use Database\Seeders\AdminSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete all files in public/patients
        $this->deletePatientsFolder();

        // Call the RoleSeeder
        $this->call(RoleSeeder::class);
        // Call the AdminSeeder
        $this->call(AdminSeeder::class);
        // Call the OpdSeeder
        $this->call(OpdSeeder::class);
        // Call the DoctorSeeder
        $this->call(DoctorSeeder::class);


        // // Seed pre-registered patient records
        PreRegisteredPatient::factory(5)->create();
        Opd::factory(5)->create();
        Doctor::factory(5)->create();

        // // Seed patient queue records
        // PatientQueue::factory(5)->create();

        // Seed user records
        // php artisan migrate:rollback && php artisan migrate:fresh --seed
    }

    /**
     * Delete all files inside public/patients directory.
     */
    private function deletePatientsFolder()
    {
        $folderPath = public_path('storage/patients');

        if (File::exists($folderPath)) {
            File::cleanDirectory($folderPath); // Deletes all files but keeps the folder
            // File::deleteDirectory($folderPath); // Use this instead if you want to remove the folder entirely
            Log::info('DatabaseSeeder@deletePatientsFolder: All files in the patients folder have been deleted.');
        } else {
            Log::info('DatabaseSeeder@deletePatientsFolder: The patients folder does not exist.');
        }
    }
}
