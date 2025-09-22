<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Master data dulu
            KategoriBukuSeeder::class,
            AnggotaSeeder::class,
            PustakawanSeeder::class,

            // Data yang bergantung pada master data
            BukuSeeder::class,
            BukuDigitalSeeder::class,

            // Data transaksi
            PeminjamanSeeder::class,
            DendaSeeder::class, // Harus setelah Peminjaman
            ReservasiSeeder::class,
        ]);
    }
}