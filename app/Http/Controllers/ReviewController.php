<?php

namespace App\Http\Controllers; // PERBAIKAN: Hanya gunakan namespace ini

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $buku_id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Pastikan model Buku menggunakan PK 'buku_id'
        $buku = Buku::where('buku_id', $buku_id)->firstOrFail();

        Review::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->buku_id,
            'comment' => $request->comment,
            'rating'  => $request->rating,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}
