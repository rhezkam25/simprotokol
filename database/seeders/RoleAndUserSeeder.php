<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Langsung buat akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@simprotokol.com',
            'role' => 'Admin', // Set role secara manual
            'phone_number' => '081234567890',
            'is_active' => true,
            'password' => Hash::make('password123'), 
        ]);
    }
}
