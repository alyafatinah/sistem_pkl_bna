<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->string('predikat', 2)
                ->nullable()
                ->after('nilai');

            $table->boolean('validasi_kaprod')
                ->default(false)
                ->after('komentar');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn(['predikat', 'validasi_kaprod']);
        });
    }
};
