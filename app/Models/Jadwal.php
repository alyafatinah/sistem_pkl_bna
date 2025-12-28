<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'angkatan',
        'periode',
        'jurusan_id',
        'pembekalan',
        'pengantaran',
        'monitoring',
        'penjemputan',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
