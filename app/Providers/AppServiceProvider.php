<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\PreRegisteredPatient;
use App\Models\User;
use App\Observers\AdminObserver;
use App\Observers\AdminRegistrationObserver;
use App\Observers\DoctorObserver;
use App\Observers\DoctorRegistrationObserver;
use App\Observers\MedicalRecordObserver;
use App\Observers\OpdObserver;
use App\Observers\OpdRegistrationObserver;
use App\Observers\PatientObserver;
use App\Observers\PatientPreRegistrationObserver;
use App\Observers\PatientQueueObserver;
use App\Observers\PatientRegistrationObserver;
use App\Observers\PreRegisteredPatientObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use PhpParser\Comment\Doc;

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
        // Register the observers
        Admin::observe(AdminObserver::class);
        Doctor::observe(DoctorObserver::class);
        Opd::observe(OpdObserver::class);
        Patient::observe(PatientObserver::class);
        PreRegisteredPatient::observe(PreRegisteredPatientObserver::class);

        PatientQueue::observe(PatientQueueObserver::class);
        MedicalRecord::observe(MedicalRecordObserver::class);


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

        Relation::morphMap([
            'admin' => 'App\Models\Admin',
            'opd' => 'App\Models\Opd',
            'doctor' => 'App\Models\Doctor',
            'patient' => 'App\Models\Patient',
        ]);
        
    }
}
