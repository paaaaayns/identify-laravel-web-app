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
                $role = Auth::user()->role;
                $user_id = Auth::user()->user_id;

                if ($role === 'admin') {
                    $user = Admin::where('user_id', $user_id)->firstOrFail();
                    $user->role = 'admin';
                } elseif ($role === 'opd') {
                    $user = Opd::where('user_id', $user_id)->firstOrFail();
                    $user->role = 'opd';
                } elseif ($role === 'doctor') {
                    $user = Doctor::where('user_id', $user_id)->firstOrFail();
                    $user->role = 'doctor';
                } elseif ($role === 'patient') {
                    $user = Patient::where('user_id', $user_id)->firstOrFail();
                    $user->role = 'patient';
                }
            }

            $view->with('user', $user);
        });

        
    }
}
