<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // Define constants for each user type prefix
    const DOCTOR_PREFIX = 'D';
    const OPD_PREFIX = 'O';
    const PATIENT_PREFIX = 'P';

    /**
     * Generate a unique UID for the user based on type and year.
     */
    public static function generateUid($type)
    {
        // Get the current year in two-digit format
        $year = now()->format('y');

        // Determine the prefix based on the user type
        switch ($type) {
            case 'doctor':
                $prefix = self::DOCTOR_PREFIX;
                break;
            case 'opd':
                $prefix = self::OPD_PREFIX;
                break;
            case 'patient':
                $prefix = self::PATIENT_PREFIX;
                break;
            default:
                throw new \Exception("Invalid user type.");
        }

        // Count existing users of this type for this year to get the next sequence number
        $count = User::where('uid', 'like', "$prefix$year-%")->count() + 1;

        // Format the count with leading zeros to make it five digits (e.g., 00001)
        $sequence = str_pad($count, 5, '0', STR_PAD_LEFT);

        // Combine parts to create the UID
        return "{$prefix}{$year}-{$sequence}";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Ensure the `type` attribute is set before generating UID
            if (!$user->type) {
                throw new \Exception("User type must be defined before generating UID.");
            }
            // Generate UID based on user type
            $user->uid = self::generateUid($user->type);
        });
    }

}
