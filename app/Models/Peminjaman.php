<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buku_id',
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_pengembalian',
    ];

    // Relasi: Satu Peminjaman milik satu Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'anggota_id');
    }

    // Relasi: Satu Peminjaman untuk satu Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }

    // Relasi: Satu Peminjaman bisa memiliki satu Denda
    public function denda()
    {
        return $this->hasOne(Denda::class, 'peminjaman_id', 'peminjaman_id');
    }
}