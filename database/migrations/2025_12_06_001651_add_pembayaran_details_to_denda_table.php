<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan tabel yang dimodifikasi adalah 'denda'
        if (Schema::hasTable('denda')) {
            Schema::table('denda', function (Blueprint $table) {
                // Kolom untuk tanggal pembayaran. Timestamp memungkinkan nilai NULL di awal.
                // Kolom ini akan diisi ketika admin menekan tombol "Catat Lunas".
                $table->timestamp('tanggal_pembayaran')->nullable()->after('status');
                
                // Kolom untuk ID pustakawan yang memproses. 
                // Menggunakan foreignId yang constrained ke tabel 'users' (asumsi pustakawan adalah user).
                $table->foreignId('id_pustakawan_pemroses')->nullable()->constrained('users')->after('tanggal_pembayaran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('denda')) {
            Schema::table('denda', function (Blueprint $table) {
                // Hapus foreign key constraint sebelum menghapus kolom
                $table->dropForeign(['id_pustakawan_pemroses']);
                
                $table->dropColumn('id_pustakawan_pemroses');
                $table->dropColumn('tanggal_pembayaran');
            });
        }
    }
};