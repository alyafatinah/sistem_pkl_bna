<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kaprod', function (Blueprint $table) {
            $table->id();

            // relasi ke users (akun login kaprodi)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // data kaprodi
            $table->string('nip')->unique();
            $table->string('nama_kaprod');
            $table->text('alamat');
            $table->string('telp');

            // relasi ke jurusan
            $table->foreignId('jurusan_id')
                  ->constrained('jurusan')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kaprod');
    }
};
