<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    // hanya contoh: tampilkan daftar buku
    public function index()
    {
        return response()->json([
            'message' => 'Daftar buku berhasil diakses!',
        ]);
    }

    // hanya contoh: tambah buku baru
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Buku baru berhasil ditambahkan!',
            'data' => $request->all()
        ]);
    }
}
