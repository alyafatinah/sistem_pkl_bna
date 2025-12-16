<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            // 1. Ubah no_hp menjadi telp
            if (Schema::hasColumn('siswa', 'no_hp')) {
                $table->renameColumn('no_hp', 'telp');
            }

            // 2. Tambah kolom mitra_id
            if (!Schema::hasColumn('siswa', 'mitra_id')) {
                $table->foreignId('mitra_id')
                    ->nullable()
                    ->after('jurusan_id')
                    ->constrained('mitra')
                    ->onDelete('set null');
            }

            // 3. Hapus kolom tempat_pkl (sudah digantikan relasi)
            if (Schema::hasColumn('siswa', 'tempat_pkl')) {
                $table->dropColumn('tempat_pkl');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            // rollback tempat_pkl
            $table->string('tempat_pkl')->nullable();

            // rollback mitra_id
            $table->dropForeign(['mitra_id']);
            $table->dropColumn('mitra_id');

            // rollback telp ke no_hp
            $table->renameColumn('telp', 'no_hp');
        });
    }
};
