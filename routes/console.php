<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\PreRegisteredPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $cutoff = Carbon::now()->subDays(7);
    $count = PreRegisteredPatient::where('created_at', '<', $cutoff)->count();
    $deleted = PreRegisteredPatient::where('created_at', '<', $cutoff)->delete();

    if ($count > 0) {
        Log::info("Console@Schedule: Deleted pre-registered patients older than 7 days.", [
            'count' => $count,
            'deleted' => $deleted,
        ]);
    }
})->everyTenSeconds();
