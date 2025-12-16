<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruPembimbing extends Model
{
    protected $table = 'gurupembimbing';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'bidang',
        'jurusan_id',
        'telp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Guru membimbing banyak siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'gurupembimbing_id');
    }
}
