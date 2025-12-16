<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model {
    protected $table = 'jurusan';

    protected $fillable = ['nama_jurusan'];

    public function siswa() {
        return $this->hasMany(Siswa::class);
    }

    public function guru() {
        return $this->hasMany(GuruPembimbing::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
