<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            // Menambahkan kolom cover setelah kolom judul, boleh kosong (nullable)
            $table->string('cover')->nullable()->after('judul');
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
};
