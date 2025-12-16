<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'deskripsi',
        'dokumentasi',
        'status ',
    ];

    /**
     * Relasi ke siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
