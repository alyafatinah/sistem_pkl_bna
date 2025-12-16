<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel siswa
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            // relasi ke tabel guru_pembimbing
            $table->foreignId('gurupembimbing_id')
                ->constrained('gurupembimbing')
                ->cascadeOnDelete();

            // nilai PKL
            $table->integer('nilai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
