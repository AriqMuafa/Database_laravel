<?php

namespace App\Http\Controllers;

use App\Models\BukuDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuDigitalController extends Controller
{
    // List semua buku digital
    public function index()
    {
        $digitalBooks = BukuDigital::with('buku')->paginate(12);

        return view('digital.index', compact('digitalBooks'));
    }

    // Detail buku digital
    public function show($id)
    {
        $book = BukuDigital::with('buku')->findOrFail($id);

        // Hit views
        $book->increment('views');

        return view('digital.show', compact('book'));
    }

    // Download file
    public function download($id)
    {
        $book = BukuDigital::findOrFail($id);

        if ($book->hak_akses === 'locked') {
            abort(403, 'Akses ke file ini dikunci.');
        }

        if (!$book->is_downloadable) {
            abort(403, 'File ini tidak dapat diunduh.');
        }

        return Storage::download($book->file_url);
    }
}
