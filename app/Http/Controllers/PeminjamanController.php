<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    /**
     * ==========================================
     * JALUR 1: MEMBER (Peminjaman Saya)
     * URL: /borrow
     * View: resources/views/books/borrow.blade.php
     * ==========================================
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $anggotaId = $user->anggota->anggota_id ?? null;

        if (!$anggotaId) {
            $data_peminjaman = collect();
        } else {
            // Ambil data milik MEMBER itu saja
            $data_peminjaman = Peminjaman::with(['buku', 'anggota', 'denda'])
                ->where('anggota_id', $anggotaId)
                ->orderBy('tanggal_pinjam', 'desc')
                ->get();
        }

        // Hitung estimasi denda untuk tampilan
        $this->hitungEstimasiDenda($data_peminjaman);

        // Arahkan ke View khusus Member
        return view('books.borrow', compact('data_peminjaman'));
    }

    /**
     * ==========================================
     * JALUR 2: ADMIN (Semua Peminjaman)
     * URL: /admin/peminjaman
     * View: resources/views/admin/peminjaman.blade.php
     * ==========================================
     */
    public function adminIndex()
    {
        // Ambil SEMUA data untuk Admin
        $data_peminjaman = Peminjaman::with(['buku', 'anggota', 'denda'])
            ->orderByRaw("FIELD(status, 'dipinjam', 'sudah dikembalikan')")
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // Hitung estimasi denda
        $this->hitungEstimasiDenda($data_peminjaman);

        // Arahkan ke View khusus Admin
        return view('admin.peminjaman', compact('data_peminjaman'));
    }

    /**
     * Helper: Menghitung estimasi denda dinamis (untuk display saja)
     */
    private function hitungEstimasiDenda($data)
    {
        $tarif_denda = 1000;
        $hari_ini = now();

        foreach ($data as $pinjam) {
            $pinjam->denda_saat_ini = 0;

            if ($pinjam->status == 'dipinjam') {
                $jatuh_tempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);

                if ($hari_ini->gt($jatuh_tempo)) {
                    $selisih_hari = $hari_ini->diffInDays($jatuh_tempo);
                    $pinjam->denda_saat_ini = $selisih_hari * $tarif_denda;
                }
            }
        }
    }

    /**
     * Menyimpan transaksi peminjaman baru (Action dari tombol "Pinjam" di Katalog)
     */
    public function store(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return redirect()->route('profile.edit')
                ->with('error', 'Lengkapi profil anggota Anda terlebih dahulu.');
        }

        $request->validate([
            'buku_id' => 'required|exists:buku,buku_id',
            'tanggal_pinjam' => 'required|date',
        ]);

        $buku = Buku::where('buku_id', $request->buku_id)->firstOrFail();
        if ($buku->stok_buku < 1) {
            return back()->with('error', 'Maaf, stok buku habis.');
        }

        $tanggal_jatuh_tempo = Carbon::parse($request->tanggal_pinjam)->addDays(7);

        try {
            DB::beginTransaction();

            Peminjaman::create([
                'id_peminjaman' => 'TR' . time() . rand(10, 99),
                'anggota_id' => $anggota->anggota_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
                'status' => 'dipinjam',
                'tanggal_pengembalian' => null
            ]);

            $buku->decrement('stok_buku');

            DB::commit();

            return redirect()->route('menu.peminjaman')->with('success', 'Berhasil meminjam buku!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

     public function create()
    {
    
        $user = Auth::user();

        $anggota = $user->anggota ?? null;

        $buku =Buku::where('stok_buku', '>', 0)->get();

        return view('books.borrow_create', compact('anggota', 'buku'));
    }

    public function cetak($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        return view('peminjaman.cetak', compact('peminjaman'));
    }
}
