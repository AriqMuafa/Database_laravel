<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman kelola reservasi (untuk admin/pustakawan).
     */
    public function index()
    {
        // Ambil semua reservasi yang masih aktif (Menunggu atau Siap Diambil)
        $reservasi = Reservasi::with(['buku', 'anggota'])
                        ->whereIn('status', ['Menunggu', 'Siap Diambil'])
                        ->orderBy('tanggal_reservasi', 'asc')
                        ->get();

        return view('admin.reservations', compact('reservasi'));
    }

    /**
     * Menandai reservasi sebagai "Siap Diambil".
     * Ini berarti buku sudah dikembalikan dan ditahan untuk anggota.
     */
    public function tandaiSiapDiambil(Reservasi $reservasi)
    {
        // Pastikan buku ada
        if (!$reservasi->buku) {
            return back()->with('error', 'Buku untuk reservasi ini tidak ditemukan.');
        }

        // Cek stok buku
        if ($reservasi->buku->stok_buku < 1) {
            return back()->with('error', 'Stok buku habis. Tidak dapat menandai siap diambil.');
        }

        DB::beginTransaction();
        try {
            // Kurangi stok buku (karena buku ditahan/di-hold)
            $reservasi->buku->decrement('stok_buku');
            
            // Ubah status reservasi
            $reservasi->update(['status' => 'Siap Diambil']);

            DB::commit();
            return back()->with('success', 'Reservasi ditandai "Siap Diambil" dan stok buku telah ditahan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Memproses reservasi menjadi peminjaman baru.
     * Ini terjadi ketika anggota datang mengambil buku yang sudah "Siap Diambil".
     */
    public function prosesPeminjaman(Reservasi $reservasi)
    {
        DB::beginTransaction();
        try {
            // 1. Buat data peminjaman baru
            $jatuh_tempo = Carbon::now()->addDays(7); // Asumsi pinjam 7 hari
            Peminjaman::create([
                'anggota_id' => $reservasi->anggota_id,
                'buku_id' => $reservasi->buku_id,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => $jatuh_tempo,
                'id_peminjaman' => 'TR' . time(), // Format ID Peminjaman
            ]);

            // 2. Hapus data reservasi (karena sudah selesai)
            $reservasi->delete();

            DB::commit();
            return back()->with('success', 'Reservasi telah berhasil diproses menjadi peminjaman.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Membatalkan reservasi.
     */
    public function batalkan(Reservasi $reservasi)
    {
        DB::beginTransaction();
        try {
            // Jika statusnya "Siap Diambil", berarti buku sedang ditahan.
            // Kita harus kembalikan stoknya.
            if ($reservasi->status == 'Siap Diambil' && $reservasi->buku) {
                $reservasi->buku->increment('stok_buku');
            }

            // Hapus reservasi
            $reservasi->delete();
            
            DB::commit();
            return back()->with('success', 'Reservasi telah dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan reservasi: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan reservasi baru (dibuat oleh user).
     */
    public function store(Buku $buku)
    {
        $user = Auth::user();

        // 1. Cek apakah user adalah anggota
        if (!$user->anggota) {
            return redirect()->route('profile.edit')->with('error', 'Anda harus melengkapi profil anggota untuk reservasi.');
        }

        $anggotaId = $user->anggota->anggota_id;

        // 2. Cek apakah stok masih ada (takutnya user curang)
        if ($buku->stok_buku > 0) {
            return back()->with('error', 'Buku ini masih tersedia dan tidak dapat direservasi.');
        }

        // 3. Cek apakah user sudah reservasi buku ini sebelumnya
        $existingReservation = Reservasi::where('buku_id', $buku->buku_id)
                                    ->where('anggota_id', $anggotaId)
                                    ->whereIn('status', ['Menunggu', 'Siap Diambil'])
                                    ->exists();

        if ($existingReservation) {
            return back()->with('error', 'Anda sudah ada dalam antrean untuk buku ini.');
        }

        // 4. Buat data reservasi baru
        Reservasi::create([
            'buku_id' => $buku->buku_id,
            'anggota_id' => $anggotaId,
            'tanggal_reservasi' => now(),
            'status' => 'Menunggu',
        ]);

        // 5. Kembali dengan notifikasi sukses
        return redirect()->back()->with('success', 'Buku telah direservasi. Silakan cek status di halaman Reservasi Saya.');
    }
    /**
     * Menampilkan halaman "Reservasi Saya" (milik user).
     */
    public function myReservations()
    {
        $anggotaId = Auth::user()->anggota->anggota_id ?? null;

        if (!$anggotaId) {
            // Jika entah bagaimana user bukan anggota tapi bisa akses
            return redirect()->route('profile.edit')->with('error', 'Anda harus melengkapi profil anggota.');
        }

        $reservasi_saya = Reservasi::with('buku')
                            ->where('anggota_id', $anggotaId)
                            ->orderBy('tanggal_reservasi', 'desc')
                            ->get();

        return view('reservations.index', compact('reservasi_saya'));
    }
}