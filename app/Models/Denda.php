<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';
    protected $primaryKey = 'denda_id';

    /**
     * Kolom-kolom yang dapat diisi secara massal (mass assignable).
     * Menambahkan kolom untuk audit trail pembayaran.
     */
    protected $fillable = [
        'peminjaman_id',
        'jumlah',
        'status',
        'tanggal_pembayaran', // Ditambahkan: Mencatat waktu pembayaran
        'id_pustakawan_pemroses', // Ditambahkan: Mencatat ID Pustakawan/Admin yang memproses
    ];

    // Relasi: Satu Denda milik satu Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }
}