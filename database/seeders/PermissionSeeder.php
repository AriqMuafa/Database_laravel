<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::insert([
            // Book related
            ['name' => 'view_books', 'display_name' => 'Lihat Buku', 'group' => 'book'],
            ['name' => 'borrow_books', 'display_name' => 'Pinjam Buku', 'group' => 'book'],
            ['name' => 'return_books', 'display_name' => 'Kembalikan Buku', 'group' => 'book'],
            ['name' => 'manage_books', 'display_name' => 'Kelola Buku', 'group' => 'book'],

            // User related
            ['name' => 'manage_users', 'display_name' => 'Kelola User', 'group' => 'user'],
            ['name' => 'register_member', 'display_name' => 'Daftar Anggota', 'group' => 'user'],

            // Reports
            ['name' => 'view_reports', 'display_name' => 'Lihat Laporan', 'group' => 'report'],
        ]);
    }
}
