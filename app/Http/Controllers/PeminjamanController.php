<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;

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
    /**
     * Proses untuk mengembalikan buku, menambah stok, dan mencatat denda jika ada.
     */
    public function kembali(Peminjaman $peminjaman)
    {
        // --- AWAL PERHITUNGAN DENDA (VERSI PERBAIKAN) ---
        $tarif_denda_per_hari = 1000;
        $hari_ini = now()->startOfDay(); // <-- Pakai startOfDay() agar perbandingan akurat
        $total_denda = 0;
        $hari_terlambat = 0;

        // Pastikan tanggal jatuh tempo valid dan set ke awal hari
        try {
             $jatuh_tempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
        } catch (\Exception $e) {
             // Jika tanggal jatuh tempo tidak valid, anggap tidak ada denda
             $jatuh_tempo = null;
             \Log::error("Invalid date format for jatuh_tempo: " . $peminjaman->tanggal_jatuh_tempo); // Catat error
        }

        // Hitung denda HANYA jika tanggal valid dan hari ini sudah lewat jatuh tempo
        if ($jatuh_tempo && $hari_ini->isAfter($jatuh_tempo)) {
             // Hitung selisih hari (gunakan parameter false agar tidak absolut, lalu ambil max 0)
             $hari_terlambat = max(0, $jatuh_tempo->diffInDays($hari_ini, false));
             $total_denda = $hari_terlambat * $tarif_denda_per_hari;
        }
        // --- AKHIR PERHITUNGAN DENDA ---
        try {
            DB::beginTransaction();

            // 1. Update tanggal pengembalian di tabel peminjaman
            $peminjaman->update([
                'tanggal_pengembalian' => $hari_ini
            ]);

            // 2. Tambahkan stok buku kembali
            $buku = $peminjaman->buku;
            if ($buku) {
                $buku->increment('stok_buku');
            } else {
                throw new \Exception('Data buku tidak ditemukan.');
            }

            // 3. JIKA ADA DENDA, buat record baru di tabel denda
            if ($total_denda > 0) {
                // Pastikan Anda sudah import model Denda di atas controller
                // use App\Models\Denda;
                Denda::create([
                    'peminjaman_id' => $peminjaman->peminjaman_id,
                    'jumlah' => $total_denda,         // <-- CORRECTED: Use 'jumlah'
                    'status' => 'belum lunas',        // <-- CORRECTED: Use 'status' and the value from your screenshot
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: Log the error
            // \Log::error('Error returning book: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengembalikan buku: Terjadi kesalahan.'); // Simplified error message
        }

        $pesan_sukses = 'Buku telah berhasil dikembalikan dan stok telah diperbarui.';
        if ($total_denda > 0) {
            $pesan_sukses .= ' Denda sebesar Rp ' . number_format($total_denda, 0, ',', '.') . ' telah dicatat.';
        }

        return back()->with('success', $pesan_sukses);
    }
    /**
     * Halaman untuk cetak nota (placeholder).
     */
    public function cetak(Peminjaman $peminjaman)
    {
        // Pastikan relasi dengan buku & anggota sudah di-load
        $peminjaman->load(['buku', 'anggota', 'denda']);

        // Kirim data ke view books/borrow_cetak.blade.php
        return view('books.borrow_cetak', compact('peminjaman'));
    }


    /**
     * Menampilkan form untuk membuat transaksi peminjaman baru.
     */
    /**
     * Menampilkan form untuk membuat transaksi peminjaman baru (UNTUK ANGGOTA).
     */
    /**
     * Menampilkan form untuk membuat transaksi peminjaman baru (UNTUK ANGGOTA).
     */
    public function create()
    {
        // Ambil data anggota dari user yang login
        $anggota = Auth::user()->anggota;

        // Jika user ini belum terdaftar sebagai anggota, paksa lengkapi profil
        if (!$anggota) {
            return redirect()->route('profile.edit')->with('error', 'Anda harus melengkapi data anggota di Profil Anda untuk meminjam.');
        }

        // Ambil semua buku yang stoknya masih ada
        $buku = Buku::where('stok_buku', '>', 0)->orderBy('judul', 'asc')->get();

        return view('books.borrow_create', compact('anggota', 'buku'));
    }

    /**
     * Menyimpan transaksi peminjaman baru ke database.
     */
    /**
     * Menyimpan transaksi peminjaman baru ke database (DARI ANGGOTA).
     */
    public function store(Request $request)
    {
        // Ambil data anggota dari user yang login
        $anggota = Auth::user()->anggota;

        // Cek lagi jika belum jadi anggota
        if (!$anggota) {
            return redirect()->route('profile.edit')->with('error', 'Anda harus melengkapi data anggota di Profil Anda untuk meminjam.');
        }

        // 1. Validasi data input (anggota_id dihapus dari validasi)
        $request->validate([
            'buku_id' => 'required|exists:buku,buku_id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Atur tanggal jatuh tempo, misal 7 hari dari tanggal pinjam
        $tanggal_jatuh_tempo = Carbon::parse($request->tanggal_pinjam)->addDays(7);

        // 2. Gunakan DB Transaction
        try {
            DB::beginTransaction();

            // 3. Simpan data peminjaman
            Peminjaman::create([
                'anggota_id' => $anggota->anggota_id, // <-- Ambil dari Auth
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
                'id_peminjaman' => 'TR' . time(), // <-- Tetap gunakan ID unik jika Anda mau
            ]);

            // 4. Kurangi stok buku
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

        // 5. Redirect kembali ke halaman "Peminjaman Saya" (books.borrow)
        return redirect()->route('books.borrow')->with('success', 'Buku berhasil dipinjam!');
    }
}