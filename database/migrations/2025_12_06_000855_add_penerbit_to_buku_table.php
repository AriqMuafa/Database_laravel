<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Kita buat nullable dulu biar data lama gak error saat migrasi
            // Nanti kita isi pake Seeder
            $table->string('penerbit')->nullable()->after('pengarang');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('penerbit');
        });
    }
};
