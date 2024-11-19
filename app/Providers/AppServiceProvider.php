<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Observers\DoctorRegistrationObserver;
use App\Observers\OpdRegistrationObserver;
use App\Observers\PatientRegistrationObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

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


        Gate::define('view-admin-dashboard', function (User $user) {
            return $user->account_type === 'admin'; // Admin can access this
        });

        Gate::define('view-opd-dashboard', function (User $user) {
            return $user->account_type === 'opd'; // OPD can access this
        });

        Gate::define('view-doctor-dashboard', function (User $user) {
            return $user->account_type === 'doctor'; // Doctor can access this
        });

        Gate::define('view-patient-dashboard', function (User $user) {
            return $user->account_type === 'patient'; // Patient can access this
        });

    }
}
