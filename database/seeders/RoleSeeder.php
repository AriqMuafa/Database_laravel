<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'pustakawan', 'display_name' => 'Pustakawan', 'description' => 'Library staff'],
            ['name' => 'anggota', 'display_name' => 'Anggota', 'description' => 'Library member'],
            ['name' => 'guest', 'display_name' => 'Guest', 'description' => 'Pengguna umum'],
        ]);
    }
}
