<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_denda_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDendaTable extends Migration
{
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id('denda_id'); // Sesuai permintaan denda_id(PK)
            $table->foreignId('peminjaman_id')->constrained('peminjaman', 'peminjaman_id');
            $table->integer('jumlah');
            $table->enum('status', ['lunas', 'belum lunas'])->default('belum lunas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
}