<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $primaryKey = 'buku_id';

    // Relasi: Satu Buku milik satu Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id', 'kategori_id');
    }

    // Relasi: Satu Buku bisa memiliki satu Buku Digital
    public function bukuDigital()
    {
        return $this->hasOne(BukuDigital::class, 'buku_id', 'buku_id');
    }

    // Relasi: Satu Buku bisa memiliki banyak Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id', 'buku_id');
    }
    
    // Relasi: Satu Buku bisa memiliki banyak Reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'buku_id', 'buku_id');
    }
}