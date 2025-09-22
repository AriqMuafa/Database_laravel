<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePustakawanTable extends Migration
{
    public function up(): void
    {
        Schema::create('pustakawan', function (Blueprint $table) {
            $table->id('pustakawan_id');
            // Kolom data pribadi, karena Pustakawan adalah entitas terpisah
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pustakawan');
    }
}