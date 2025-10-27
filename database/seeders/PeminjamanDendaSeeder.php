<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Buku;
use App\Models\Anggota;

class PeminjamanDendaSeeder extends Seeder
{
    public function run(): void
    {
        $buku1 = Buku::find(1);
        $buku2 = Buku::find(2);

        $anggota1 = Anggota::find(1);
        $anggota2 = Anggota::find(2);

        // Peminjaman yang masih berjalan
        $peminjaman1 = Peminjaman::create([
            'buku_id' => $buku1->buku_id,
            'anggota_id' => $anggota1->anggota_id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->addDays(2),
        ]);

        // Tidak ada denda karena belum terlambat
        Denda::create([
            'peminjaman_id' => $peminjaman1->id,
            'jumlah' => 0,
            'status' => 'belum_bayar',
        ]);

        // Peminjaman yang sudah selesai (contoh terlambat)
        $peminjaman2 = Peminjaman::create([
            'buku_id' => $buku2->buku_id,
            'anggota_id' => $anggota2->anggota_id,
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_jatuh_tempo' => now()->subDays(3),
            'tanggal_pengembalian' => now()->subDays(1), // Terlambat 2 hari
        ]);

        // Hitung jumlah denda, misal 5000 per hari
        $hariTerlambat = $peminjaman2->tanggal_pengembalian->diffInDays($peminjaman2->tanggal_jatuh_tempo);
        $jumlahDenda = $hariTerlambat * 5000;

        Denda::create([
            'peminjaman_id' => $peminjaman2->id,
            'jumlah' => $jumlahDenda,
            'status' => 'belum_bayar',
        ]);
    }
}
