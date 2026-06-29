<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->foreignId('posisi_id')
                ->nullable()
                ->constrained('posisis')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropForeign(['posisi_id']);
            $table->dropColumn('posisi_id');
        });
    }
};