<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orang extends Model
{
    use HasFactory;
    protected $table = 'orang';
    protected $fillable = ['nama', 'alamat', 'telepon'];

    // Relasi: Satu Orang bisa jadi Anggota
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'orang_id');
    }

    // public function pustakawan() // <--- HAPUS FUNGSI INI
    // {
    //     return $this->hasOne(Pustakawan::class, 'orang_id');
    // }
}