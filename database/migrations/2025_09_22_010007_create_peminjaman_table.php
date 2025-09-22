<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_peminjaman_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('peminjaman_id'); // Sesuai permintaan peminjaman_id(PK)
            $table->foreignId('buku_id')->constrained('buku', 'buku_id');
            $table->foreignId('anggota_id')->constrained('anggota', 'anggota_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
}