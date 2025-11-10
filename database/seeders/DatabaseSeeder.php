<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Master data non-user (kategori, role, permission)
            KategoriBukuSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,

            // 2. Data penghubung role & permission
            RolePermissionSeeder::class,

            // 3. Buat user (yang butuh data dari RoleSeeder)
            UserSeeder::class,

            // 4. Buat data yang bergantung pada User (Anggota/Pustakawan)
            AnggotaSeeder::class,
            PustakawanSeeder::class,

            // 5. Data buku (bergantung pada kategori)
            BukuSeeder::class,
            BukuDigitalSeeder::class,

            // 6. Data transaksi (bergantung pada Anggota dan Buku)
            PeminjamanSeeder::class,
            DendaSeeder::class, // Harus setelah Peminjaman
            ReservasiSeeder::class,

            CreateUsersForAnggotaSeeder::class,
        ]);
    }
}