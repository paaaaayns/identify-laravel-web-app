<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterDoctorController;
use App\Http\Controllers\RegisterOpdController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('auth')->name('dashboard');


// Register OPD
Route::get('/register/opd', [RegisterOpdController::class, 'create'])->middleware('auth');
Route::post('/register/opd', [RegisterOpdController::class, 'store'])->middleware('auth');

// Register Doctor
Route::get('/register/doctor', [RegisterDoctorController::class, 'create'])->middleware('auth');
Route::post('/register/doctor', [RegisterDoctorController::class, 'store'])->middleware('auth');
