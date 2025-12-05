<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpiredMemberController extends Controller
{
    /**
     * Menampilkan daftar anggota yang masa berlakunya sudah kadaluarsa.
     * Masa berlaku keanggotaan adalah 5 tahun dari tanggal_daftar.
     */
    public function index()
    {
        // Hitung tanggal batas kadaluarsa: 5 tahun yang lalu dari hari ini.
        $expiredDateLimit = Carbon::now()->subYears(5);

        // Ambil anggota di mana tanggal_daftar LEBIH LAMA dari 5 tahun yang lalu.
        $expiredMembers = Anggota::where('tanggal_daftar', '<', $expiredDateLimit)
            ->orderBy('tanggal_daftar', 'asc') // Urutkan dari yang paling lama kadaluarsa
            ->paginate(20); // Gunakan pagination agar halaman tidak berat

        return view('admin.expired', compact('expiredMembers', 'expiredDateLimit'));
    }

    /**
     * Menghapus anggota yang sudah kadaluarsa dari database.
     * @param int $id ID dari Anggota yang akan dihapus.
     */
    public function destroy($id)
    {
        try {
            $anggota = Anggota::findOrFail($id);
            $anggotaNama = $anggota->nama;
            
            // Validasi keamanan: Pastikan memang anggota tersebut sudah expired sebelum dihapus
            $expiredDateLimit = Carbon::now()->subYears(5);
            if ($anggota->tanggal_daftar >= $expiredDateLimit) {
                return redirect()->route('admin.expired')->with('error', 'Anggota ' . $anggotaNama . ' belum kadaluarsa, penghapusan dibatalkan.');
            }

            $anggota->delete();

            return redirect()->route('admin.expired')->with('success', 'Anggota kadaluarsa (' . $anggotaNama . ') berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.expired')->with('error', 'Gagal menghapus anggota. Pastikan anggota tidak memiliki relasi data aktif (misalnya peminjaman aktif).');
        }
    }
}