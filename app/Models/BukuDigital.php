<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuDigital extends Model
{
    use HasFactory;

    protected $table = 'buku_digital';
    protected $primaryKey = 'buku_digital_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buku_id',
        'file_url',
        'hak_akses',
    ];

    // Relasi: Satu BukuDigital milik satu Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }
}