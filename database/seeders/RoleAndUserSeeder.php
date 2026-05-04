<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat 3 Role sesuai rancangan MVP
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleKoordinator = Role::create(['name' => 'Koordinator']);
        $roleAnggota = Role::create(['name' => 'Anggota']);

        // Buat akun Super Admin
        $admin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'rhezkayoga@kjripenang.my',
            'phone_number' => '01168536145',
            'is_active' => true,
            'password' => Hash::make('password123'), // Ingat password ini untuk login
        ]);

        // Berikan role Admin ke akun tersebut
        $admin->assignRole($roleAdmin);
    }
}
