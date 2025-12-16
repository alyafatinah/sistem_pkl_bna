<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'jurusan')) {
                $table->dropColumn('jurusan');
            }
        });
    }

    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('jurusan')->nullable();
        });
    }
};
