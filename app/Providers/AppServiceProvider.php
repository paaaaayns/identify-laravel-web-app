<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Observers\DoctorRegistrationObserver;
use App\Observers\OpdRegistrationObserver;
use App\Observers\PatientRegistrationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Doctor::observe(DoctorRegistrationObserver::class);
        Opd::observe(OpdRegistrationObserver::class);
        Patient::observe(PatientRegistrationObserver::class);
    }
}
