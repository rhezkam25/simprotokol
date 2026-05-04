<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; //1.Import Spatie

//#[Fillable(['name', 'email', 'password'])]
//#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles; //add HasRoles spatie
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number', 
        'is_active',    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
   // 4. Pastikan tipe data is_active dibaca sebagai boolean
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', 
        ];
    }
}
