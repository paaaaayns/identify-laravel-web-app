<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use App\Observers\DoctorRegistrationObserver;
use App\Observers\OpdRegistrationObserver;
use App\Observers\PatientRegistrationObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\AdminRegistrationObserver;
use App\Observers\PatientPreRegistrationObserver;
use Illuminate\Support\Facades\Auth;

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
        // Share the admin instance globally if the user is authenticated
        view()->composer('*', function ($view) {
            $user = null;

            if (Auth::check()) {
                $type = Auth::user()->type;
                $user_id = Auth::user()->user_id;

                if ($type === 'ADMIN') {
                    $user = Admin::where('user_id', $user_id)->firstOrFail();
                    $user->account_type = 'ADMIN';
                } elseif ($type === 'OPD') {
                    $user = Opd::where('user_id', $user_id)->firstOrFail();
                    $user->account_type = 'OPD';
                } elseif ($type === 'DOCTOR') {
                    $user = Doctor::where('user_id', $user_id)->firstOrFail();
                    $user->account_type = 'DOCTOR';
                } elseif ($type === 'PATIENT') {
                    $user = Patient::where('user_id', $user_id)->firstOrFail();
                    $user->account_type = 'PATIENT';
                }
            }

            $view->with('user', $user);
        });


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

        Gate::define('view-patient-index', function (User $user) {
            return in_array($user->account_type, ['ADMIN', 'OPD']); // Admin can access this
        });
    }
}
