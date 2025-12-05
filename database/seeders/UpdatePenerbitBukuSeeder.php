<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku; // Pastikan Model Buku di-import
use Illuminate\Support\Arr; // Helper untuk array acak

class UpdatePenerbitBukuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Daftar Penerbit Dummy
        $daftarPenerbit = [
            'Gramedia Pustaka Utama',
            'Elex Media Komputindo',
            'Bentang Pustaka',
            'Mizan',
            'Republika Penerbit',
            'Gagas Media',
            'Andi Offset',
            'Erlangga'
        ];

        // 2. Ambil semua buku
        $books = Buku::all();

        $this->command->info("Mengupdate penerbit untuk " . $books->count() . " buku...");

        foreach ($books as $book) {
            // Pilih satu penerbit secara acak
            $penerbitAcak = Arr::random($daftarPenerbit);

            // Update datanya
            $book->update([
                'penerbit' => $penerbitAcak
            ]);
        }

        $this->command->info("Selesai! Semua buku sekarang punya penerbit.");
    }
}
