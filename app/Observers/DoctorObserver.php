<?php

namespace App\Observers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorObserver
{
    public function created(Doctor $doctor)
    {
        try {
            $doctor->user_id = 'D-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
            $doctor->ulid = Str::ulid();
            $doctor->saveQuietly();

            $user = User::create([
                'user_id' => $doctor->user_id,
                'email' => $doctor->email,
                'password' => Hash::make('Password@123'),
                'role' => 'doctor',
            ]);

            $user->assignRole('doctor');

            event(new Registered($user));
        } catch (\Exception $e) {
            Log::error('DoctorObserver@created: Error creating User for doctor: ' . $e->getMessage(), [
                'doctor_id' => $doctor->user_id,
                'email' => $doctor->email,
            ]);

            $doctor->delete();

            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
