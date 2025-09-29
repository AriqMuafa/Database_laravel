<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role dari tabel roles
        $adminRole = Role::where('name', 'admin')->first();
        $pustakawanRole = Role::where('name', 'pustakawan')->first();

        // Buat akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'arabelazlf@gmail.com',
            'password' => Hash::make('password'), // ✅ default password
            'role_id' => $adminRole->id,
        ]);

        // Buat akun Pustakawan
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'cekkerjaan123@gmail.com',
            'password' => Hash::make('password'), // ✅ default password
            'role_id' => $pustakawanRole->id,
        ]);
    }
}
