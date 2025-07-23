<?php

use App\Mail\PreRegistrationDeletionMail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\PreRegisteredPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $cutoff = Carbon::now()->subDays(7);

    DB::transaction(function () use ($cutoff) {
        PreRegisteredPatient::where('created_at', '<', $cutoff)->chunkById(50, function ($patients) {
            foreach ($patients as $patient) {
                try {
                    Mail::to($patient->email)->send(new PreRegistrationDeletionMail($patient));
                    $patient->delete();
                } catch (\Exception $e) {
                    Log::error("Console@Schedule: Failed to send email or delete patient.", [
                        'patient_id' => $patient->id,
                        'email' => $patient->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        });
    });
})->everyTenSeconds();
