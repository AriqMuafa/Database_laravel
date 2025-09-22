<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_kategori_buku_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriBukuTable extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_buku', function (Blueprint $table) {
            $table->id('kategori_id'); // Sesuai permintaan Kategori_id(PK)
            $table->string('nama_kategori');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_buku');
    }
}