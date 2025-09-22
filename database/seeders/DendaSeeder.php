<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denda;
use App\Models\Peminjaman;

class DendaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil peminjaman yang sudah dikembalikan
        $peminjaman = Peminjaman::find(2);

        Denda::create([
            'peminjaman_id' => $peminjaman->peminjaman_id,
            'jumlah' => 2000, // Denda 2 hari x Rp 1000
            'status' => 'belum lunas'
        ]);
    }
}