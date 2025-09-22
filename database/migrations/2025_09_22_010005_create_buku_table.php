<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('buku_id');
            $table->foreignId('kategori_id')->constrained('kategori_buku', 'kategori_id');
            $table->string('judul');
            $table->string('pengarang');
            $table->year('tahun_terbit');
            $table->text('sinopsis')->nullable();
            $table->integer('stok_buku')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
}