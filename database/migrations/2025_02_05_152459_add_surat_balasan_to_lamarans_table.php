<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuratBalasanToLamaransTable extends Migration
{
    public function up()
{
    Schema::table('lamarans', function (Blueprint $table) {
        $table->string('surat_balasan_path')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('lamarans', function (Blueprint $table) {
        $table->dropColumn('surat_balasan_path');
    });
}

}
