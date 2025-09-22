<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;
    protected $table = 'kategori_buku';
    protected $primaryKey = 'kategori_id';

    // Relasi: Satu Kategori memiliki banyak Buku
    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'kategori_id');
    }
}