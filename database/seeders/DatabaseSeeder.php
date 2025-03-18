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
        $this->call(AdminSeeder::class);
        $this->call(OpdSeeder::class);
        $this->call(DoctorSeeder::class);

        // DEV NOTE (TESTING): Uncomment the lines below to seed dummy data during testing
        PreRegisteredPatient::factory(5)->create();
        Opd::factory(5)->create();
        Doctor::factory(5)->create();
    }

    /**
     * Delete all files inside public/patients directory.
     */
    private function deletePatientsFolder()
    {
        $folderPath = public_path('storage/patients');

        if (File::exists($folderPath)) {
            File::cleanDirectory($folderPath);
            Log::info('DatabaseSeeder@deletePatientsFolder: All files in the patients folder have been deleted.');
        } else {
            Log::info('DatabaseSeeder@deletePatientsFolder: The patients folder does not exist.');
        }
    }
}
