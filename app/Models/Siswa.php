<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Mitra;
use App\Models\Jurnal;
use App\Models\GuruPembimbing;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'kelas',
        'alamat',
        'telp',
        'jurusan_id',
        'mitra_id',
        'gurupembimbing_id'
    ];

    /**
     * Relasi ke tabel users (akun login siswa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke jurusan
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi ke mitra PKL
     */
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

    public function guruPembimbing()
    {
        return $this->belongsTo(GuruPembimbing::class, 'gurupembimbing_id');
    }
}
