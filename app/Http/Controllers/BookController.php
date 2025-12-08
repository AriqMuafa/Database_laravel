<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Denda;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku dengan fitur pencarian, filter kategori, dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk filter dropdown
        $kategori = KategoriBuku::orderBy('nama_kategori', 'asc')->get();

        // 2. Ambil query parameter
        $searchQuery = $request->input('search');
        $categoryFilter = $request->input('category');

        // 3. Mulai query dengan eager loading relasi kategori
        $booksQuery = Buku::with('kategori');

        // 4. Terapkan filter Kategori
        if ($categoryFilter) {
            $booksQuery->where('kategori_id', $categoryFilter);
        }

        // 5. Terapkan filter Pencarian
        if ($searchQuery) {
            $booksQuery->where(function ($query) use ($searchQuery) {
                $query->where('judul', 'like', '%' . $searchQuery . '%')
                    ->orWhere('pengarang', 'like', '%' . $searchQuery . '%')
                    ->orWhere('penerbit', 'like', '%' . $searchQuery . '%') // Tambahan dari Current
                    ->orWhere('sinopsis', 'like', '%' . $searchQuery . '%');
            });
        }

        // 6. Ambil hasilnya dengan pagination (12 buku per halaman)
        $books = $booksQuery->orderBy('judul', 'asc')->paginate(12)->withQueryString();

        return view('books.index', compact('books', 'searchQuery', 'kategori', 'categoryFilter'));
    }

    // manage book (Admin List)
    public function manage()
    {
        $books = Buku::with('kategori')->get();
        return view('books.manage', compact('books'));
    }

    /**
     * Menampilkan form untuk menambah buku baru.
     */
    public function create()
    {
        $kategori = KategoriBuku::orderBy('nama_kategori', 'asc')->get();
        return view('books.create', compact('kategori'));
    }

    /**
     * Menyimpan buku baru (dengan Upload Gambar dari Current)
     */
    public function store(Request $request)
    {
        // 1. Validasi data (Gabungan Current & Incoming)
        $validatedData = $request->validate([
            'judul'         => 'required|string|max:255',
            'cover'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Fitur Current
            'pengarang'     => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255', // Fitur Current
            'tahun_terbit'  => 'required|integer|digits:4|min:1000|max:' . date('Y'),
            'sinopsis'      => 'nullable|string',
            'stok_buku'     => 'required|integer|min:0',
            'kategori_id'   => 'required|exists:kategori_buku,kategori_id',
        ]);

        // 2. Logika Upload Gambar (Dari Current)
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $validatedData['cover'] = $path;
        }

        // 3. Simpan ke Database
        try {
            Buku::create($validatedData);
            return redirect()->route('books.manage')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Error adding book: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    public function edit(Buku $book)
    {
        $kategori = KategoriBuku::all();
        return view('books.edit', [
            'book' => $book,
            'kategori' => $kategori
        ]);
    }

    /**
     * Update buku (dengan Upload Gambar dari Current)
     */
    public function update(Request $request, Buku $book)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'judul'         => 'required|string|max:255',
            'cover'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pengarang'     => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255',
            'tahun_terbit'  => 'required|integer|digits:4|min:1000|max:' . date('Y'),
            'sinopsis'      => 'nullable|string',
            'stok_buku'     => 'required|integer|min:0',
            'kategori_id'   => 'required|exists:kategori_buku,kategori_id',
        ]);

        // 2. Logika Upload Gambar Baru (Dari Current)
        if ($request->hasFile('cover')) {
            // Hapus gambar lama jika ada
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // Simpan gambar baru
            $path = $request->file('cover')->store('covers', 'public');
            $validatedData['cover'] = $path;
        } else {
            // Jangan update kolom cover jika tidak ada file baru
            unset($validatedData['cover']);
        }

        // 3. Update Database
        $book->update($validatedData);

        return redirect()->route('books.manage')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $book)
    {
        // Hapus file gambar cover juga (Dari Current)
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.manage')->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Menampilkan Detail Buku & Related Books (Dari Current)
     * Method ini PENTING dipertahankan karena Incoming tidak memilikinya.
     */
    public function show($id)
    {
        // 1. Load buku beserta relasi kategori dan review+usernya
        $book = Buku::with(['reviews.user', 'kategori', 'bukuDigital'])
            ->where('buku_id', $id)
            ->firstOrFail();

        // 2. Logic Buku Relevan (Related Products)
        $relatedBooks = Buku::where('kategori_id', $book->kategori_id)
            ->where('buku_id', '!=', $id) // Jangan tampilkan buku yg sedang dibuka
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }

    public function showDenda($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan.');
        }

        $denda = Denda::find($order->denda_id);

        return view('books.borrow_cetak', compact('order', 'denda'));
    }
}
