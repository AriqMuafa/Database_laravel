<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\KategoriBuku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID dari kategori yang sudah ada
        $kategoriTeknologi = KategoriBuku::where('nama_kategori', 'Teknologi')->first();
        $kategoriFiksi = KategoriBuku::where('nama_kategori', 'Fiksi Ilmiah')->first();

        Buku::create([
            'kategori_id' => $kategoriTeknologi->kategori_id,
            'judul' => 'Dasar-Dasar Pemrograman Web',
            'pengarang' => 'Dr. John Doe',
            'tahun_terbit' => '2023',
            'sinopsis' => 'Buku pengantar untuk mempelajari pengembangan web modern.',
            'stok_buku' => 5
        ]);

        Buku::create([
            'kategori_id' => $kategoriFiksi->kategori_id,
            'judul' => 'Jelajah Antariksa',
            'pengarang' => 'Jane Smith',
            'tahun_terbit' => '2021',
            'sinopsis' => 'Kisah petualangan di galaksi yang jauh.',
            'stok_buku' => 3
        ]);
    }
}