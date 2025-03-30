<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\IrisBiometricsController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientQueueController;
use App\Http\Controllers\PreRegisteredPatientController;
use App\Http\Controllers\PreRegistrationController;
use App\Http\Controllers\PreRegTrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Mail\PreRegistrationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/login');
});

Route::get('/token', function () {
    return csrf_token();
});


// Login
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::post('/verify-password', [UserController::class, 'verifyPassword']);
Route::get('/verify-email', [UserController::class, 'verifyEmail']);


// Pre-Registration Public Routes
Route::get('/pre-register', [PreRegistrationController::class, 'create'])->name('pre-reg.create');
Route::post('/pre-register/store', [PreRegistrationController::class, 'store'])->name('pre-reg.store'); // TOD0: Implement this

Route::get('/pre-register/search', [PreRegTrackingController::class, 'index'])->name('pre-reg.tracking.search');
Route::get('/pre-register/track/search', [PreRegTrackingController::class, 'show'])->name('pre-reg.tracking.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard')
        ->middleware(['role:admin|opd|doctor|patient']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('users/{user_id}/profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');
    Route::post('users/{user_id}/password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    // Pre-Registered Patient
    Route::get('/users/pre-reg', [PreRegisteredPatientController::class, 'index'])->name('users.pre-reg.index');
    Route::get('/users/pre-reg/create', [PreRegisteredPatientController::class, 'create'])->name('users.pre-reg.create');
    Route::post('/users/pre-reg/validate-store-request', [PreRegisteredPatientController::class, 'validateStoreRequest']);
    Route::post('/users/pre-reg/store', [PreRegisteredPatientController::class, 'store'])->name('users.pre-reg.store');
    Route::get('/users/pre-reg/{ulid}', [PreRegisteredPatientController::class, 'show'])->name('users.pre-reg.show');
    Route::delete('/users/pre-reg/{user_id}', [PreRegisteredPatientController::class, 'destroy'])->name('users.pre-reg.destroy');


    // Patient
    Route::get('/users/patient', [PatientController::class, 'index'])->name('users.patient.index');
    Route::post('/users/patient/validate-store-request', [PatientController::class, 'validateStoreRequest']);
    Route::post('/users/patient/store', [PatientController::class, 'store'])->name('users.patient.store');
    Route::get('/users/patient/{ulid}', [PatientController::class, 'show'])->name('users.patient.show');
    Route::delete('/users/patient/{user_id}', [PatientController::class, 'destroy'])->name('users.patient.destroy');


    // OPD
    Route::get('/users/opd', [OpdController::class, 'index'])->name('users.opd.index');
    Route::get('/users/opd/create', [OpdController::class, 'create'])->name('users.opd.create');
    Route::post('/users/opd/validate-store-request', [OpdController::class, 'validateStoreRequest']);
    Route::post('/users/opd/store', [OpdController::class, 'store'])->name('users.opd.store');
    Route::get('/users/opd/{ulid}', [OpdController::class, 'show'])->name('users.opd.show');
    Route::delete('/users/opd/{user_id}', [OpdController::class, 'destroy'])->name('users.opd.destroy');


    // Doctor
    Route::get('/users/doctor', [DoctorController::class, 'index'])->name('users.doctor.index');
    Route::get('/users/doctor/create', [DoctorController::class, 'create'])->name('users.doctor.create');
    Route::post('/users/doctor/store', [DoctorController::class, 'store'])->name('users.doctor.store');
    Route::post('/users/doctor/validate-store-request', [DoctorController::class, 'validateStoreRequest']);
    Route::get('/users/doctor/{ulid}', [DoctorController::class, 'show'])->name('users.doctor.show');
    Route::delete('/users/doctor/{user_id}', [DoctorController::class, 'destroy'])->name('users.doctor.destroy');


    // Queued Patient
    Route::get('/queue', [PatientQueueController::class, 'index'])->name('queue.index');
    Route::post('/queue/store', [PatientQueueController::class, 'store'])->name('queue.store');
    Route::put('/queue/{ulid}', [PatientQueueController::class, 'update'])->name('queue.update');
    Route::get('/queue/{ulid}', [PatientQueueController::class, 'show'])->name('queue.show');
    Route::delete('/queue/{ulid}', [PatientQueueController::class, 'destroy'])->name('queue.destroy');


    // Medical Records
    Route::get('/medical-record', [MedicalRecordController::class, 'index'])->name('medical-record.index');
    Route::get('/history', [MedicalRecordController::class, 'index'])->name('history.index');
    Route::get('/api/medical-record/{ulid}/download', [MedicalRecordController::class, 'download'])
        ->name('medical-record.download');

    // Iris Biometrics
    Route::post('/iris-biometrics/search', [IrisBiometricsController::class, 'search'])->name('iris-biometrics.search');
});


Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


// Test email
Route::get('/test-prereg-mail', function () {
    $email = '';

    $data = [
        'code' => 'test-code',
        'trackingLink' => route('pre-reg.tracking.search'),
    ];

    try {
        Mail::to($email)->send(new PreRegistrationMail($data));
    } catch (\Exception $e) {
        Log::error('web@test-prereg-mail: ', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email!',
            'error' => $e->getMessage(),
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Test email sent!',
    ], 200);
});
