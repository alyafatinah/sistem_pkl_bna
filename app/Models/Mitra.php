<?php

namespace App\Models;
use App\Models\Siswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    protected $table = 'mitra';
    protected $fillable = [
        'nama_mitra',
        'bidang',
        'alamat',
        'pl',
        'telp'
    ];

        public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
