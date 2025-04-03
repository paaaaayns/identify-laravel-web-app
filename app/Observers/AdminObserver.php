<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminObserver
{
    public function created(Admin $admin)
    {
        try {
            $admin->user_id = 'A-' . str_pad($admin->id, 5, '0', STR_PAD_LEFT);
            $admin->ulid = Str::ulid();
            $admin->saveQuietly();

            $user = User::create([
                'user_id' => $admin->user_id,
                'email' => $admin->email,
                'password' => Hash::make('Password@123'),
                'role' => 'admin',
            ]);

            $user->assignRole('admin');

            event(new Registered($user));
        } catch (\Exception $e) {
            Log::error('AdminObserver@created: Error creating User for admin: ' . $e->getMessage(), [
                'admin_id' => $admin->user_id,
                'email' => $admin->email,
            ]);

            $admin->delete();

            if (isset($user)) {
                $user->delete();
            }
        }
    }
}
