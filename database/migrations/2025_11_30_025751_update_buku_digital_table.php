<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            $table->string('format')->nullable()->after('file_url');          // PDF / EPUB / dll
            $table->string('cover')->nullable()->after('format');             // path gambar cover
            $table->text('deskripsi')->nullable()->after('cover');            // deskripsi digital
            $table->boolean('is_downloadable')->default(false)->after('hak_akses');
            $table->integer('size')->nullable()->after('is_downloadable');    // ukuran file dalam KB/MB
            $table->unsignedBigInteger('views')->default(0)->after('size');   // jumlah dilihat
            $table->string('watermarked_file_url')->nullable()->after('views'); // versi watermarked
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            $table->dropColumn([
                'format',
                'cover',
                'deskripsi',
                'is_downloadable',
                'size',
                'views',
                'watermarked_file_url'
            ]);
        });
    }
};
