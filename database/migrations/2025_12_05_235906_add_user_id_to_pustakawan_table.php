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
        Schema::table('pustakawan', function (Blueprint $table) {
            $table->foreignId('user_id')      // Membuat kolom user_id
                ->after('pustakawan_id')    // Menaruhnya setelah ID biar rapi
                ->nullable()                // PENTING: Agar data lama tidak error
                ->unique()                  // 1 User = 1 Pustakawan
                ->constrained('users')      // Terhubung ke id di tabel users
                ->onDelete('cascade');      // Jika User dihapus, data Pustakawan ikut hapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pustakawan', function (Blueprint $table) {
            // Hapus foreign key dan kolomnya jika rollback
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
