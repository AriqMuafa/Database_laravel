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
        Schema::table('anggota', function (Blueprint $table) {
            $table->foreignId('user_id')      // Membuat kolom 'user_id'
                  ->after('anggota_id')    // (Opsional) Biar rapi, posisinya setelah 'anggota_id'
                  ->nullable()             // PENTING! Agar data lama Anda tidak error
                  ->unique()               // PENTING! Untuk relasi User -> hasOne -> Anggota
                  ->constrained('users')   // Menghubungkan ke 'id' di tabel 'users'
                  ->onDelete('set null'); // Jika user dihapus, kolom 'user_id' ini jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            // Ini untuk 'rollback', urutannya dibalik
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};