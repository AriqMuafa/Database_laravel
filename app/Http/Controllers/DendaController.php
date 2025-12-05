<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Ditambahkan untuk logging error

class DendaController extends Controller
{
    /**
     * Menampilkan daftar denda milik anggota yang sedang login (Fungsi Lama Anda).
     */
    public function index()
    {
        // Ambil ID anggota yang sedang login
        $anggotaId = Auth::user()->anggota->anggota_id ?? null;

        if (!$anggotaId) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Ambil semua denda milik anggota yang login dengan eager loading
        $denda = Denda::whereHas('peminjaman', function ($query) use ($anggotaId) {
            $query->where('anggota_id', $anggotaId);
        })
        ->with('peminjaman.buku') // Tambahkan eager loading relasi buku
        ->get();

        return view('menu.peminjaman', compact('denda'));
    }

    /**
     * Menampilkan daftar denda yang statusnya 'belum lunas' untuk Admin/Pustakawan.
     * Mengganti fungsionalitas adminIndex() yang lama.
     */
    public function adminIndex()
    {
        // Ambil semua denda yang statusnya belum lunas
        // Eager load relasi yang diperlukan (Peminjaman -> Anggota & Buku)
        $dendaBelumLunas = Denda::where('status', 'belum lunas')
            ->with(['peminjaman' => function ($query) {
                // Eager load nested relations Anggota dan Buku
                $query->with(['anggota', 'buku']);
            }])
            ->latest('denda_id') // Urutkan berdasarkan denda terbaru
            ->get();

        // Menggunakan view fines.admin
        return view('fines.admin', compact('dendaBelumLunas')); 
    }

    /**
     * Memproses pembayaran denda (mengubah status menjadi 'lunas') oleh Admin/Pustakawan.
     * @param int $id ID dari Denda yang akan diproses.
     */
    public function prosesPembayaran($id)
    {
        $denda = Denda::find($id);

        // Guard: Pastikan denda ada dan belum lunas
        if (!$denda || $denda->status == 'lunas') {
            return redirect()->route('fines.admin')->with('error', 'Denda tidak ditemukan atau sudah lunas.');
        }

        try {
            // Ambil ID Pustakawan yang sedang login. Default ke ID 1 jika Auth::id() tidak tersedia.
            $pustakawanId = Auth::check() ? Auth::id() : 1; 

            // Update status denda dan audit trail
            $denda->status = 'lunas';
            $denda->tanggal_pembayaran = now();
            $denda->id_pustakawan_pemroses = $pustakawanId; 
            $denda->save();

            return redirect()->route('fines.admin')->with('success', 
                'Pembayaran denda ID ' . $denda->denda_id . ' (Rp ' . number_format($denda->jumlah) . ') berhasil dicatat.');

        } catch (\Exception $e) {
            Log::error('Gagal memproses pembayaran denda ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('fines.admin')->with('error', 'Terjadi kesalahan sistem saat memproses pembayaran. Silakan cek log.');
        }
    }
}