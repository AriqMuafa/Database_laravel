<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Peminjaman; // <-- Pastikan ini di-import
use App\Models\Anggota;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan halaman transaksi peminjaman (gambar Anda).
     */
    public function index()
    {
        // Mengambil semua data peminjaman YANG BELUM DIKEMBALIKAN
        // 'with(['anggota', 'buku'])' adalah Eager Loading
        // Ini mengambil data relasi agar efisien
        $data_peminjaman = Peminjaman::with(['anggota', 'buku'])
                            ->whereNull('tanggal_pengembalian') // <-- Hanya tampilkan yang masih dipinjam
                            ->orderBy('tanggal_pinjam', 'asc')
                            ->get();

        // Kirim data ke view
        return view('books.borrow', compact('data_peminjaman'));
    }

    /**
     * Proses untuk mengembalikan buku.
     */
    public function kembali(Peminjaman $peminjaman)
    {
        // Update kolom 'tanggal_pengembalian' dengan tanggal hari ini
        $peminjaman->update([
            'tanggal_pengembalian' => now()
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Buku telah berhasil dikembalikan.');
    }

    /**
     * Halaman untuk cetak nota (placeholder).
     */
    public function cetak(Peminjaman $peminjaman)
    {
        // Anda bisa tambahkan logika untuk generate PDF atau halaman cetak di sini
        // Untuk sekarang, kita hanya tampilkan pesan
        return "Halaman Cetak Nota untuk Peminjaman ID: " . $peminjaman->id;
    }

    /**
     * Menampilkan form untuk membuat transaksi peminjaman baru.
     */
    public function create()
    {
        // Ambil semua anggota untuk dropdown
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        
        // Ambil semua buku yang stoknya masih ada
        $buku = Buku::where('stok_buku', '>', 0)->orderBy('judul', 'asc')->get();

        return view('books.borrow_create', compact('anggota', 'buku'));
    }

    /**
     * Menyimpan transaksi peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data input
        $request->validate([
            // Cek di tabel 'anggota' pada kolom 'anggota_id'
            'anggota_id' => 'required|exists:anggota,anggota_id',
            
            // Cek di tabel 'buku' pada kolom 'buku_id'
            'buku_id' => 'required|exists:buku,buku_id',
            
            'tanggal_pinjam' => 'required|date',
        ]);

        // Atur tanggal jatuh tempo, misal 7 hari dari tanggal pinjam
        $tanggal_jatuh_tempo = Carbon::parse($request->tanggal_pinjam)->addDays(7);

        // 2. Gunakan DB Transaction untuk memastikan data konsisten
        try {
            DB::beginTransaction();

            // 3. Simpan data peminjaman
            Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
                'id_peminjaman' => 'TR032' . time(), // Buat ID Transaksi unik (sesuaikan format Anda)
            ]);

            // 4. Kurangi stok buku
            $buku = Buku::find($request->buku_id);
            $buku->decrement('stok_buku');

            DB::commit(); // Simpan semua perubahan jika sukses

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            // Kembali ke form dengan pesan error
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }

        // 5. Redirect kembali ke halaman utama dengan pesan sukses
        return redirect()->route('books.borrow')->with('success', 'Transaksi peminjaman baru berhasil ditambahkan.');
    }
}