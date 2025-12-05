<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role (update or insert supaya tidak duplicate)
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'pustakawan', 'display_name' => 'Pustakawan', 'description' => 'Library staff'],
            ['name' => 'anggota', 'display_name' => 'Anggota', 'description' => 'Library member'],
            ['name' => 'guest', 'display_name' => 'Guest', 'description' => 'Pengguna umum'],
        ];

        foreach ($roles as $role) {
            Role::updateOrInsert(['name' => $role['name']], $role);
        }

        // Ambil role dari DB
        $admin       = Role::where('name', 'admin')->first();
        $pustakawan  = Role::where('name', 'pustakawan')->first();
        $anggota     = Role::where('name', 'anggota')->first();

        // Permission CRUD Digital Books
        $crudDigital = Permission::whereIn('name', [
            'access_digital_books',
            'create_digital_books',
            'edit_digital_books',
            'delete_digital_books',
        ])->get();

        // Permission hanya akses
        $accessOnly = Permission::where('name', 'access_digital_books')->first();

        // Assign ke admin & pustakawan (crud lengkap)
        $admin->permissions()->syncWithoutDetaching($crudDigital->pluck('id'));
        $pustakawan->permissions()->syncWithoutDetaching($crudDigital->pluck('id'));

        // Anggota hanya bisa lihat / akses
        $anggota->permissions()->syncWithoutDetaching([$accessOnly->id]);
    }
}
