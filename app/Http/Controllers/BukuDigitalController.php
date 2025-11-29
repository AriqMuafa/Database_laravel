<?php

namespace App\Http\Controllers;

use App\Models\BukuDigital;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuDigitalController extends Controller
{
    // ==========================
    // LIST
    // ==========================
    public function index()
    {
        $digitalBooks = BukuDigital::with('buku')->paginate(12);

        return view('digital.index', compact('digitalBooks'));
    }

    // ==========================
    // DETAIL
    // ==========================
    public function show($id)
    {
        $book = BukuDigital::with('buku')->findOrFail($id);

        // Hit views
        $book->increment('views');

        return view('digital.show', compact('book'));
    }

    // ==========================
    // DOWNLOAD
    // ==========================
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

    // ============================================================
    // ============================ CRUD ===========================
    // ============================================================

    /**
     * Form tambah buku digital
     */
    public function create()
    {
        $books = Buku::all(); // Untuk pilih buku induk
        return view('digital.create', compact('books'));
    }

    /**
     * Simpan buku digital
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id'        => 'required|exists:buku,buku_id',
            'file_url'       => 'required|file|mimes:pdf,epub|max:200000',
            'hak_akses'      => 'required|in:open access,locked',
            'cover'          => 'nullable|image|max:5000',
            'deskripsi'      => 'nullable|string',
            'is_downloadable'=> 'boolean',
        ]);

        // Upload file buku
        $filePath = $request->file('file_url')->store('digital_files', 'public');

        // Upload cover
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('digital_covers', 'public')
            : null;

        // Insert ke DB
        BukuDigital::create([
            'buku_id'        => $request->buku_id,
            'file_url'       => $filePath,
            'hak_akses'      => $request->hak_akses,
            'cover'          => $coverPath,
            'deskripsi'      => $request->deskripsi,
            'is_downloadable'=> $request->is_downloadable ?? 0,
            'size'           => $request->file('file_url')->getSize(),
            'views'          => 0,
            'watermarked_file_url' => null, // opsional
        ]);

        return redirect()->route('digital.index')
            ->with('success', 'Buku digital berhasil ditambahkan.');
    }

    /**
     * Form edit buku digital
     */
    public function edit($id)
    {
        $book = BukuDigital::with('buku')->findOrFail($id);
        $books = Buku::all();

        return view('digital.edit', compact('book', 'books'));
    }

    /**
     * Update data buku digital
     */
    public function update(Request $request, $id)
    {
        $book = BukuDigital::findOrFail($id);

        $request->validate([
            'hak_akses'      => 'required|in:open access,locked',
            'deskripsi'      => 'nullable|string',
            'is_downloadable'=> 'boolean',
            'file_url'       => 'nullable|file|mimes:pdf,epub|max:200000',
            'cover'          => 'nullable|image|max:5000',
        ]);

        // Update file jika ada upload baru
        if ($request->hasFile('file_url')) {
            Storage::delete('public/' . $book->file_url);
            $book->file_url = $request->file('file_url')->store('digital_files', 'public');
            $book->size = $request->file('file_url')->getSize();
        }

        // Update cover jika ada upload baru
        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $book->cover = $request->file('cover')->store('digital_covers', 'public');
        }

        $book->update([
            'hak_akses'      => $request->hak_akses,
            'deskripsi'      => $request->deskripsi,
            'is_downloadable'=> $request->is_downloadable ?? 0,
        ]);

        return redirect()->route('digital.show', $id)
            ->with('success', 'Buku digital berhasil diperbarui.');
    }

    /**
     * Hapus buku digital
     */
    public function destroy($id)
    {
        $book = BukuDigital::findOrFail($id);

        Storage::delete('public/' . $book->file_url);

        if ($book->cover) {
            Storage::delete('public/' . $book->cover);
        }

        $book->delete();

        return redirect()->route('digital.index')
            ->with('success', 'Buku digital berhasil dihapus.');
    }
}
