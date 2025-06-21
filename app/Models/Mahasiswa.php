<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $fillable = [
        'nama',
        'nim',
        'prodi_id'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matakuliah()
    {
        return $this->belongsToMany(Matakuliah::class, 'krs', 'mahasiswa_id', 'matakuliah_id');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');  
    }
}
