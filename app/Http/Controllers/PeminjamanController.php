<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    /**
     * METHOD UNTUK HALAMAN /borrow (Tampilan USER - HANYA data user)
     */
    public function index()
    {
        // 1. Dapatkan ID Anggota dari User yang login
        $anggotaId = Auth::user()->anggota->anggota_id ?? null;

        // Jika user bukan anggota, tampilkan data kosong
        if (!$anggotaId) {
            $data_peminjaman = collect(); // Buat koleksi kosong
        } else {
            // 2. Ambil data peminjaman HANYA untuk anggota_id ini
            $data_peminjaman = Peminjaman::with(['buku', 'anggota']) // Tetap ambil 'anggota'
                ->where('anggota_id', $anggotaId)
                ->whereNull('tanggal_pengembalian') // Hanya yang masih dipinjam
                ->orderBy('tanggal_pinjam', 'asc')
                ->get();
        }

        // 3. Hitung denda (logika ini sama seperti sebelumnya)
        $tarif_denda_per_hari = 1000;
        $hari_ini = now();

        foreach ($data_peminjaman as $pinjam) {
            $jatuh_tempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);
            $total_denda = 0;
            if ($hari_ini->isAfter($jatuh_tempo)) {
                $hari_terlambat = $hari_ini->diffInDays($jatuh_tempo);
                $total_denda = $hari_terlambat * $tarif_denda_per_hari;
            }
            $pinjam->denda_saat_ini = $total_denda;
        }

        // 4. Kirim data ke view 'books.borrow'
        return view('books.borrow', compact('data_peminjaman'));
    }

    /**
     * METHOD UNTUK HALAMAN /admin/peminjaman (Tampilan ADMIN - Menampilkan SEMUA data)
     */
    public function adminIndex()
    {
        // Tetapkan tarif denda per hari (Rp 1000)
        $tarif_denda_per_hari = 1000;
        $hari_ini = now();

        // Ambil semua data peminjaman YANG BELUM DIKEMBALIKAN
        $data_peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->whereNull('tanggal_pengembalian')
            ->orderBy('tanggal_pinjam', 'asc')
            ->get();

        // Hitung denda untuk setiap peminjaman
        foreach ($data_peminjaman as $pinjam) {
            $jatuh_tempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);
            $total_denda = 0;

            // Hitung denda HANYA jika hari ini sudah melewati tanggal jatuh tempo
            if ($hari_ini->isAfter($jatuh_tempo)) {
                $hari_terlambat = $hari_ini->diffInDays($jatuh_tempo);
                $total_denda = $hari_terlambat * $tarif_denda_per_hari;
            }

            // Tambahkan properti 'denda_saat_ini' ke objek peminjaman
            $pinjam->denda_saat_ini = $total_denda;
        }

        // Kirim data ke view 'admin.peminjaman'
        return view('admin.peminjaman', compact('data_peminjaman'));
    }

    /**
     * Proses untuk mengembalikan buku dan menambah stok.
     */
    public function kembali(Peminjaman $peminjaman)
    {
        // Gunakan DB Transaction untuk memastikan 2 aksi berjalan sukses
        try {
            DB::beginTransaction();

            // 1. Update kolom 'tanggal_pengembalian'
            $peminjaman->update([
                'tanggal_pengembalian' => now()
            ]);

            // 2. Tambahkan stok buku kembali
            $buku = $peminjaman->buku;
            if ($buku) {
                $buku->increment('stok_buku');
            } else {
                throw new \Exception('Data buku tidak ditemukan.');
            }

            DB::commit(); // Simpan semua perubahan jika sukses

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            return back()->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Buku telah berhasil dikembalikan dan stok telah diperbarui.');
    }

    /**
     * Halaman untuk cetak nota (placeholder).
     */
    public function cetak(Peminjaman $peminjaman)
    {
        // Pastikan relasi dengan buku & anggota sudah di-load
        $peminjaman->load(['buku', 'anggota']);

        // Kirim data ke view books/borrow_cetak.blade.php
        return view('books.borrow_cetak', compact('peminjaman'));
    }


    /**
     * Menampilkan form untuk membuat transaksi peminjaman baru.
     */
    public function create()
    {
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        $buku = Buku::where('stok_buku', '>', 0)->orderBy('judul', 'asc')->get();

        return view('books.borrow_create', compact('anggota', 'buku'));
    }

    /**
     * Menyimpan transaksi peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,anggota_id',
            'buku_id' => 'required|exists:buku,buku_id',
            'tanggal_pinjam' => 'required|date',
        ]);

        $tanggal_jatuh_tempo = Carbon::parse($request->tanggal_pinjam)->addDays(7);

        try {
            DB::beginTransaction();

            Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
                'id_peminjaman' => 'TR032' . time(),
            ]);

            $buku = Buku::where('buku_id', $request->buku_id)->first();
            if ($buku) {
                $buku->decrement('stok_buku');
            } else {
                throw new \Exception('Data buku tidak ditemukan saat pengurangan stok.');
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }

        // Redirect ke halaman Admin, bukan halaman user
        return redirect()->route('admin.peminjaman.index')->with('success', 'Transaksi peminjaman baru berhasil ditambahkan.');
    }
}