<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        Anggota::create([
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Pahlawan No. 10, Semarang',
            'telepon' => '081234567890',
            'tanggal_daftar' => now()
        ]);

        Anggota::create([
            'nama' => 'Citra Lestari',
            'alamat' => 'Jl. Gajah Mada No. 25, Semarang',
            'telepon' => '087654321098',
            'tanggal_daftar' => now()
        ]);
    }
}