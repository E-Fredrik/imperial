<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_number
 * @property string $status
 * @property string $role
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Booking[] $bookings
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'phone_number',
        'status',
        'role',
        'remember_token'
    ];

    /**
     * Combine first_name + last_name for Breeze (expects "name").
     */
    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Allow setting "name" (Breeze) — split into first_name / last_name.
     */
    public function setNameAttribute(?string $value): void
    {
        $value = trim((string) $value);
        if ($value === '') {
            $this->attributes['first_name'] = null;
            $this->attributes['last_name'] = null;
            return;
        }

        $parts = preg_split('/\s+/', $value);
        $this->attributes['first_name'] = $parts[0] ?? null;
        $this->attributes['last_name'] = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : null;
    }

    /**
     * Auto-hash password when set.
     */
    public function setPasswordAttribute(?string $value): void
    {
        if (empty($value)) {
            $this->attributes['password'] = null;
            return;
        }

        // If value is already a hash (Hash::needsRehash returns false), keep it.
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
