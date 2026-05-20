<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable; // Spatie HasRoles sudah dihapus

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // Tambahkan role
        'phone_number', 
        'is_active',    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', 
        ];
    }

    // --- FUNGSI BANTUAN UNTUK CEK ROLE MANUAL ---
    public function isAdmin() {
        return $this->role === 'Admin';
    }

    public function isKoordinator() {
        return $this->role === 'Koordinator';
    }

    public function isAnggota() {
        return $this->role === 'Anggota';
    }
}
