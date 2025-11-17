<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('asal_sekolah');
            $table->string('jurusan');
            $table->integer('semester');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('surat_pengantar_path');
            $table->string('cv_path')->nullable();
            $table->enum('status', [
                'pending',
                'diterima',
                'ditolak',
                'revisi',
                'magang_berjalan',
                'magang_selesai'
            ])->default('pending');
            $table->string('surat_diterima_path')->nullable();
            $table->string('surat_ditolak_path')->nullable();
            $table->text('catatan_revisi')->nullable();
            $table->string('sertifikat_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lamarans');
    }
};