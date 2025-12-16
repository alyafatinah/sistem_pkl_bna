<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'alamat')) {
                $table->string('alamat')->nullable();
            }
            if (!Schema::hasColumn('siswa', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }
            if (!Schema::hasColumn('siswa', 'jurusan_id')) {
                $table->unsignedBigInteger('jurusan_id')->nullable();
            }
            if (!Schema::hasColumn('siswa', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_hp', 'jurusan_id', 'user_id']);
        });
    }
};
