<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $buku = Buku::find(1); // Ambil buku pertama
        $anggota = Anggota::find(1); // Ambil anggota pertama

        // Peminjaman yang masih berjalan
        Peminjaman::create([
            'buku_id' => $buku->buku_id,
            'anggota_id' => $anggota->anggota_id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->addDays(2),
        ]);
        
        // Peminjaman yang sudah selesai untuk contoh Denda
        Peminjaman::create([
            'buku_id' => 2, // Ambil buku kedua
            'anggota_id' => 2, // Ambil anggota kedua
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_jatuh_tempo' => now()->subDays(3),
            'tanggal_pengembalian' => now()->subDays(1), // Terlambat 2 hari
        ]);
    }
}