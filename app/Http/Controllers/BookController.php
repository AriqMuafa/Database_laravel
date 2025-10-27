<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    // tampilkan daftar buku
    public function index()
    {
        // ambil data buku + nama kategori
        $books = DB::table('buku')
            ->join('kategori_buku', 'buku.kategori_id', '=', 'kategori_buku.kategori_id')
            ->select(
                'buku.buku_id',
                'buku.judul',
                'buku.pengarang',
                'buku.tahun_terbit',
                'buku.sinopsis',
                'buku.stok_buku',
                'kategori_buku.nama_kategori'
            )
            ->get();

        return view('books.index', compact('books'));
    }

    // manage book
    public function manage()
    {
        $books = Buku::with('kategori')->get();
        return view('books.manage', compact('books'));
    }


    // tambah buku baru
    /**
     * Menampilkan form untuk menambah buku baru.
     */
    public function create()
    {
        // Ambil semua kategori buku dari database
        $kategori = KategoriBuku::orderBy('nama_kategori', 'asc')->get(); // Gunakan $kategori agar konsisten dengan view edit Anda

        // Kirim data kategori ke view 'books.create'
        return view('books.create', compact('kategori')); // Kirim variabel $kategori
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'sinopsis' => 'nullable|string',
            'stok_buku' => 'required|integer',
            'kategori_id' => 'required|exists:kategori_buku,kategori_id',
        ]);

        Buku::create($request->all());

        return redirect()->route('books.manage')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Buku $book)
    {
        $kategori = KategoriBuku::all();
        return view('books.edit', [
            'book' => $book,
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, Buku $book)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'sinopsis' => 'nullable|string',
            'stok_buku' => 'required|integer',
            'kategori_id' => 'required|exists:kategori_buku,kategori_id',
        ]);

        $book->update($request->all());

        return redirect()->route('books.manage')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $book)
    {
        $book->delete();

        return redirect()->route('books.manage')->with('success', 'Buku berhasil dihapus!');
    }
}