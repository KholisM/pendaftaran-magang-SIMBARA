<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('lamarans', 'surat_diterima_path')) {
                $table->string('surat_diterima_path')->nullable()->after('status');
            }
            if (!Schema::hasColumn('lamarans', 'surat_ditolak_path')) {
                $table->string('surat_ditolak_path')->nullable()->after('surat_diterima_path');
            }
            if (!Schema::hasColumn('lamarans', 'catatan_revisi')) {
                $table->text('catatan_revisi')->nullable()->after('surat_ditolak_path');
            }
            if (!Schema::hasColumn('lamarans', 'sertifikat_path')) {
                $table->string('sertifikat_path')->nullable()->after('catatan_revisi');
            }
        });

        // Modifikasi kolom status hanya jika belum memiliki nilai 'revisi'
        $enumCheck = DB::select("SHOW COLUMNS FROM lamarans LIKE 'status'");
        if (!empty($enumCheck)) {
            $type = $enumCheck[0]->Type;
            if (strpos($type, 'revisi') === false) {
                DB::statement("ALTER TABLE lamarans MODIFY COLUMN status ENUM('pending', 'diterima', 'ditolak', 'revisi', 'magang_berjalan', 'magang_selesai') DEFAULT 'pending'");
            }
        }
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $drop = [];

            if (Schema::hasColumn('lamarans', 'surat_diterima_path')) {
                $drop[] = 'surat_diterima_path';
            }
            if (Schema::hasColumn('lamarans', 'surat_ditolak_path')) {
                $drop[] = 'surat_ditolak_path';
            }
            if (Schema::hasColumn('lamarans', 'catatan_revisi')) {
                $drop[] = 'catatan_revisi';
            }
            if (Schema::hasColumn('lamarans', 'sertifikat_path')) {
                $drop[] = 'sertifikat_path';
            }

            if (!empty($drop)) {
                $table->dropColumn($drop);
            }
        });

        // Kembalikan enum status ke versi awal
        DB::statement("ALTER TABLE lamarans MODIFY COLUMN status ENUM('pending', 'diterima', 'ditolak', 'magang_berjalan', 'magang_selesai') DEFAULT 'pending'");
    }
};
