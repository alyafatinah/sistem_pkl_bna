<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('angkatan');
            $table->foreignId('jurusan_id')
                  ->constrained('jurusan')
                  ->cascadeOnDelete();
            $table->date('pembekalan');
            $table->date('pengantaran');
            $table->date('monitoring');
            $table->date('penjemputan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
