
<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_reservasi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasiTable extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('reservasi_id'); // Sesuai permintaan reservasi_id(PK)
            $table->foreignId('buku_id')->constrained('buku', 'buku_id');
            $table->foreignId('anggota_id')->constrained('anggota', 'anggota_id');
            $table->date('tanggal_reservasi');
            $table->enum('status', ['Pending', 'Selesai', 'Batal'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
}