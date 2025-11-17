<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Personal Information
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->text('alamat');
            // Academic Information
            $table->string('asal_sekolah');
            $table->string('jurusan');
            $table->integer('semester');
            $table->decimal('ipk', 3, 2);
            $table->string('profile_photo')->nullable()->default('/images/default-profile.png');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biodatas');
    }
};