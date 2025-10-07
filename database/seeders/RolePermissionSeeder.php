<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role
        $admin = Role::where('name', 'admin')->first();
        $pustakawan = Role::where('name', 'pustakawan')->first();
        $anggota = Role::where('name', 'anggota')->first();
        $guest = Role::where('name', 'guest')->first();

        // Admin dapat semua permission
        $admin->permissions()->sync(Permission::all()->pluck('id'));

        // Pustakawan
        $pustakawan->permissions()->sync(
            Permission::whereIn('name', [
                'view_books',
                'manage_books',
                'return_books',
                'manage_categories',
                'view_members',
                'manage_reservations',
                'view_fines',
                'manage_fines',
                'access_digital_books',
            ])->pluck('id')
        );

        // Anggota
        $anggota->permissions()->sync(
            Permission::whereIn('name', [
                'view_books',
                'borrow_books',
                'view_fines',         // hanya denda sendiri
                'reserve_books',
                'access_digital_books',
            ])->pluck('id')
        );

        // Guest
        $guest->permissions()->sync(
            Permission::whereIn('name', [
                'view_books',
                'register_member',
            ])->pluck('id')
        );
    }
}