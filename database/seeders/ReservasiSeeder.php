<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservasi;

class ReservasiSeeder extends Seeder
{
    public function run(): void
    {
        Reservasi::create([
            'buku_id' => 1,
            'anggota_id' => 2,
            'tanggal_reservasi' => now(),
            'status' => 'Pending'
        ]);
    }
}