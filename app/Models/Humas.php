<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Humas extends Model
{
    protected $table = 'humas';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_humas',
        'alamat',
        'telp',
    ];

    // relasi: humas milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
