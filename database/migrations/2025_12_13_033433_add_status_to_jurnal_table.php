<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jurnal', function (Blueprint $table) {
            if (!Schema::hasColumn('jurnal', 'status')) {
                $table->enum('status', ['menunggu', 'disetujui', 'revisi'])
                    ->default('menunggu')
                    ->after('dokumentasi');
            }
        });
    }


    public function down(): void
    {
        Schema::table('jurnal', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
