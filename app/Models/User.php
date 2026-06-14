<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // role: 0=student, 1=admin, 2=teacher
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'role',
        'password',
        'age',
        'numri_amzes',
        'grade',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }
}
