<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'nilai',
        'komentar',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
