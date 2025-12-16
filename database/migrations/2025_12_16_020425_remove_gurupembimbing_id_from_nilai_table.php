<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            // HAPUS foreign key dulu
            $table->dropForeign(['gurupembimbing_id']);

            // HAPUS kolom
            $table->dropColumn('gurupembimbing_id');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->foreignId('gurupembimbing_id')
                  ->constrained('gurupembimbing')
                  ->cascadeOnDelete();
        });
    }
};
