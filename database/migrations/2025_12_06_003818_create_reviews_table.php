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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // PK tabel reviews (tetap id)

            // 1. Relasi ke User (Standard: PK user adalah 'id')
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 2. Relasi ke Buku (Custom: PK buku adalah 'buku_id')
            // Kita buat kolom 'buku_id' dulu
            $table->unsignedBigInteger('buku_id');

            // Lalu kita set foreign key-nya secara manual
            $table->foreign('buku_id')
                ->references('buku_id') // Kolom target di tabel bukus
                ->on('buku')
                ->onDelete('cascade');

            $table->text('comment');
            $table->unsignedTinyInteger('rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
