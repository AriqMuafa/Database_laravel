<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBukuDigitalTable extends Migration
{
    public function up()
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            $table->string('format_file')->after('file_url');
            $table->float('ukuran_file')->after('format_file')->comment('Size in MB');
        });
    }

    public function down()
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            $table->dropColumn(['format_file', 'ukuran_file']);
        });
    }
}