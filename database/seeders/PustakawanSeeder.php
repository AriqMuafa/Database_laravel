<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pustakawan;

class PustakawanSeeder extends Seeder
{
    public function run(): void
    {
        // Langsung buat data Pustakawan tanpa membuat Orang
        Pustakawan::create([
            'nama' => 'Rina Amelia',
            'alamat' => 'Jl. Merdeka No. 5, Semarang',
            'telepon' => '081223344556'
        ]);

        Pustakawan::create([
            'nama' => 'Agus Wijoyo',
            'alamat' => 'Jl. Kartini No. 12, Semarang',
            'telepon' => '085667788990'
        ]);
    }
}