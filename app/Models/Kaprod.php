<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Jurusan;

class Kaprod extends Model
{
    // Nama tabel
    protected $table = 'kaprod';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'nip',
        'nama_kaprod',
        'alamat',
        'telp',
        'jurusan_id',
    ];

    /**
     * Relasi ke tabel users (akun login Kaprodi)
     * Kaprod -> User (many to one)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel jurusan
     * Kaprod -> Jurusan (many to one)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
