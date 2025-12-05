<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            
            // --- BAGIAN I: MENAMBAH KOLOM ANGGOTA_ID YANG HILANG ---
            
            // Kita bungkus dengan pengecekan, kalau-kalau migrasi gagal di tengah jalan
            if (!Schema::hasColumn('peminjaman', 'anggota_id')) {
                // Tambahkan kolom anggota_id yang hilang
                $table->foreignId('anggota_id')
                      ->constrained('anggota', 'anggota_id') // Merujuk ke tabel anggota
                      ->onDelete('restrict') // Aturan: Anggota tidak bisa dihapus jika masih ada peminjaman
                      ->after('buku_id'); 
            }

            // --- BAGIAN II: MENAMBAH CONSTRAINT PADA KOLOM BUKU_ID YANG SUDAH ADA ---

            // Kita harus memastikan Foreign Key lama (yang menyebabkan error 1091) sudah hilang,
            // atau jika kolomnya sudah ada tapi tidak ada constraint, kita pasang yang baru.

            // 1. Coba hapus Foreign Key lama (jika ada)
            try {
                $table->dropForeign('peminjaman_buku_id_foreign'); 
            } catch (\Exception $e) {
                // Abaikan error jika foreign key tidak ada (karena memang itu masalahnya)
            }
            
            // 2. Tambahkan Foreign Key baru ke buku_id (onDelete('cascade'))
            $table->foreign('buku_id')
                  ->references('buku_id')->on('buku')
                  ->onDelete('cascade'); // Aturan: Jika Buku dihapus, Peminjaman ikut terhapus
        });
    }

    public function down(): void
    {
        // Logika rollback
        Schema::table('peminjaman', function (Blueprint $table) {
            // Drop constraint buku_id
            $table->dropForeign(['buku_id']);
            
            // Drop constraint dan kolom anggota_id
            $table->dropForeign(['anggota_id']);
            $table->dropColumn('anggota_id');
        });
    }
};