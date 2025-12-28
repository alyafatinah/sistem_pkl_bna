<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id'
    ];


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function guruPembimbing()
    {
        return $this->hasOne(GuruPembimbing::class);
    }

    public function kaprod()
    {
        return $this->hasOne(Kaprod::class);
    }

    public function humas()
    {
        return $this->hasOne(Humas::class);
    }
}
