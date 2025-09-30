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
            ['name' => 'view_members', 'display_name' => 'Lihat Daftar Anggota', 'group' => 'user'],
            ['name' => 'manage_expired_members', 'display_name' => 'Kelola Anggota Kadaluarsa', 'group' => 'user'],

            //Denda
            ['name' => 'view_fines', 'display_name' => 'Lihat Denda', 'group' => 'fine'],
            ['name' => 'manage_fines', 'display_name' => 'Kelola Denda', 'group' => 'fine'],

            //Reservasi
            ['name' => 'reserve_books', 'display_name' => 'Reservasi Buku', 'group' => 'reservation'],
            ['name' => 'manage_reservations', 'display_name' => 'Kelola Reservasi', 'group' => 'reservation'],

            //Buku Digital
            ['name' => 'access_digital_books', 'display_name' => 'Akses Buku Digital', 'group' => 'ebook'],

            // Reports
            ['name' => 'view_reports', 'display_name' => 'Lihat Laporan', 'group' => 'report'],
        ]);
    }
}
