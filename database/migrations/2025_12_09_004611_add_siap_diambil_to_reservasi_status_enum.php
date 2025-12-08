<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiapDiambilToReservasiStatusEnum extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan Schema::table untuk memodifikasi tabel yang sudah ada
        Schema::table('reservasi', function (Blueprint $table) {
            // Menambahkan 'Siap Diambil' ke daftar ENUM yang ada
            $table->enum('status', ['Pending', 'Siap Diambil', 'Selesai', 'Batal'])->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations (opsional, untuk rollback).
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            // Mengembalikan ENUM ke daftar semula jika rollback
            $table->enum('status', ['Pending', 'Selesai', 'Batal'])->default('Pending')->change();
        });
    }
}