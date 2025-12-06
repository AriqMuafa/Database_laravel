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
    // tampilkan daftar buku
    public function index()
    {
        // ambil data buku + nama kategori
        $books = DB::table('buku')
            ->join('kategori_buku', 'buku.kategori_id', '=', 'kategori_buku.kategori_id')
            ->select(
                'buku.buku_id',
                'buku.judul',
                'buku.cover',
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
        // 1. Validasi data input (lebih spesifik)
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

        if ($request->hasFile('cover')) {
            // Simpan gambar dan ambil path-nya
            $path = $request->file('cover')->store('covers', 'public');
            // PERBAIKAN: Masukkan path gambar ke dalam array $validatedData
            $validatedData['cover'] = $path;
        }

        // 2. Buat record baru (gunakan try...catch)
        try {
            // PERBAIKAN: Gunakan $validatedData yang sudah berisi path cover (jika ada)
            Buku::create($validatedData);

            return redirect()->route('books.manage')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Error adding book: ' . $e->getMessage());
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

        // 2. Logika Upload Gambar Baru
        if ($request->hasFile('cover')) {
            if ($book->cover && \Storage::disk('public')->exists($book->cover)) {
                \Storage::disk('public')->delete($book->cover);
            }

            // Simpan gambar baru
            $path = $request->file('cover')->store('covers', 'public');

            // Masukkan path baru ke array validasi
            $validatedData['cover'] = $path;
        } else {
            unset($validatedData['cover']);
        }

        // 3. Update Database
        $book->update($validatedData);

        return redirect()->route('books.manage')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $book)
    {
        if ($book->cover && \Storage::disk('public')->exists($book->cover)) {
            \Storage::disk('public')->delete($book->cover);
        }

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

    public function show($id)
    {
        // 1. Load buku beserta relasi kategori dan review+usernya
        $book = Buku::with(['reviews.user', 'kategori'])
            ->where('buku_id', $id)
            ->firstOrFail();

        // 2. Logic Buku Relevan (Fixed)
        // Gunakan 'kategori_id' bukan 'kategori' object
        $relatedBooks = Buku::where('kategori_id', $book->kategori_id)
            ->where('buku_id', '!=', $id) // Jangan tampilkan buku yg sedang dibuka
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }
}
