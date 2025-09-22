<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pustakawan extends Model
{
    use HasFactory;

    protected $table = 'pustakawan';
    protected $primaryKey = 'pustakawan_id';
    
    // Kembalikan fillable untuk menampung datanya sendiri
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
    ];

    // Tidak ada relasi ke model Orang di sini
}