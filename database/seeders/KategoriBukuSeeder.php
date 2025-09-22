<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBuku;

class KategoriBukuSeeder extends Seeder
{
    public function run(): void
    {
        KategoriBuku::create(['nama_kategori' => 'Fiksi Ilmiah']);
        KategoriBuku::create(['nama_kategori' => 'Novel Sejarah']);
        KategoriBuku::create(['nama_kategori' => 'Teknologi']);
    }
}