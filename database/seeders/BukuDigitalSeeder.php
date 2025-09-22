<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\BukuDigital;

class BukuDigitalSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID dari buku yang sudah ada
        $buku = Buku::where('judul', 'Dasar-Dasar Pemrograman Web')->first();

        BukuDigital::create([
            'buku_id' => $buku->buku_id,
            'file_url' => 'https://example.com/ebooks/dasar-pemrograman.pdf',
            'hak_akses' => 'locked'
        ]);
    }
}