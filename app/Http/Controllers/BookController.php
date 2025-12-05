<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Denda;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku dengan fitur pencarian, filter kategori, dan pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk ditampilkan di filter dropdown (penting!)
        $kategori = KategoriBuku::orderBy('nama_kategori', 'asc')->get();

        // 2. Ambil query parameter
        $searchQuery = $request->input('search');
        $categoryFilter = $request->input('category'); // Parameter baru untuk filter kategori

        // 3. Mulai query dengan eager loading relasi kategori
        $booksQuery = Buku::with('kategori');

        // 4. Terapkan filter Kategori (NEW)
        if ($categoryFilter) {
            $booksQuery->where('kategori_id', $categoryFilter);
        }

        // 5. Terapkan filter Pencarian
        if ($searchQuery) {
            // Gunakan closure untuk memastikan filter pencarian TIDAK mengganggu filter kategori
            $booksQuery->where(function ($query) use ($searchQuery) {
                $query->where('judul', 'like', '%' . $searchQuery . '%')
                      ->orWhere('pengarang', 'like', '%' . $searchQuery . '%')
                      ->orWhere('sinopsis', 'like', '%' . $searchQuery . '%');
            });
        }

        // 6. Ambil hasilnya dengan pagination
        // Menggunakan withQueryString() agar semua parameter filter dan pencarian tetap ada
        $books = $booksQuery->orderBy('judul', 'asc')->paginate(12)->withQueryString();

        return view('books.index', compact('books', 'searchQuery', 'kategori', 'categoryFilter'));
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
        $kategori = KategoriBuku::orderBy('nama_kategori', 'asc')->get();

        // Kirim data kategori ke view 'books.create'
        return view('books.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data input (lebih spesifik)
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            // Tambahkan aturan digits, min, max
            'tahun_terbit' => 'required|integer|digits:4|min:1000|max:' . date('Y'),
            'sinopsis' => 'nullable|string',
            // Tambahkan aturan min
            'stok_buku' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategori_buku,kategori_id',
        ]);

        // 2. Buat record baru (gunakan try...catch)
        try {
            // Gunakan $validatedData agar hanya data tervalidasi yang disimpan
            Buku::create($validatedData);
            return redirect()->route('books.manage')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan
            \Log::error('Error adding book: ' . $e->getMessage()); // Catat error di log
            // Kembali ke form dengan input lama dan pesan error
            return back()->withInput()->with('error', 'Gagal menambahkan buku. Silakan coba lagi.');
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

    public function showDenda($id)
    {
        // 1️⃣ Ambil order berdasarkan ID dari URL
        $order = Order::find($id);

        // 2️⃣ Pastikan order ditemukan
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan.');
        }

        // 3️⃣ Ambil data denda berdasarkan denda_id dari order
        $denda = Denda::find($order->denda_id);

        // 4️⃣ Kirim ke view
        return view('books.borrow_cetak', compact('order', 'denda'));
    }

    
}