<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_buku_digital_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuDigitalTable extends Migration
{
    public function up(): void
    {
        Schema::create('buku_digital', function (Blueprint $table) {
            $table->id('buku_digital_id'); // Sesuai permintaan buku_digital_id(PK)
            $table->foreignId('buku_id')->unique()->constrained('buku', 'buku_id')->onDelete('cascade');
            $table->string('file_url');
            $table->string('hak_akses')->comment('Contoh: open access, locked');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_digital');
    }
}