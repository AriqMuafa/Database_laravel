<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'buku_id', 'comment', 'rating'];

    public function user()
    {
        // Komentar milik SATU user
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        // Komentar milik SATU buku
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }
}