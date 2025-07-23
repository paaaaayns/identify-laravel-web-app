<?php

namespace App\Observers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OpdObserver
{
    public function created(Opd $opd)
    {
        try {
            $opd->user_id = 'O-' . str_pad($opd->id, 5, '0', STR_PAD_LEFT);
            $opd->ulid = Str::ulid();
            $opd->saveQuietly();

            $user = User::create([
                'user_id' => $opd->user_id,
                'email' => $opd->email,
                'password' => Hash::make('Password@123'),
                'role' => 'opd',
            ]);

            $user->assignRole('opd');

            event(new Registered($user));
        } catch (\Exception $e) {
            Log::error('OpdObserver@created: Error creating User for opd: ' . $e->getMessage(), [
                'opd_id' => $opd->user_id,
                'email' => $opd->email,
            ]);

            $opd->delete();

            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
