<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'anggota_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'tanggal_daftar',
    ];

    // Relasi: Satu Anggota bisa memiliki banyak Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id', 'anggota_id');
    }

    // Relasi: Satu Anggota bisa memiliki banyak Reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'anggota_id', 'anggota_id');
    }
}