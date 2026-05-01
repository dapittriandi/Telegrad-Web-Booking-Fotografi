<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
    'name',
    'email',
    'username',
    'password',
    'photo',
    'phone', 
    'role',
    'is_verified',
    'verify_token',
    'token_created_at',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getPhoneAttribute($value)
    {
        if (strpos($value, '0') === 0) {
            return '+62' . substr($value, 1);
        }

        return $value;
    }

    // Relasi order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}