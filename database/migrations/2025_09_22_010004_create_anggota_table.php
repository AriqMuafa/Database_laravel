<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_anggota_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id('anggota_id'); // Sesuai permintaan anggota_id(PK)
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
            $table->date('tanggal_daftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
}