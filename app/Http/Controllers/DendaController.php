<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DendaController extends Controller // <--- PERHATIKAN NAMA CLASS INI
{
    /**
     * Menampilkan daftar denda BELUM LUNAS (Untuk Admin/Pustakawan)
     */
    public function adminIndex()
    {
        // Ambil denda yang belum lunas beserta relasinya
        $dendaBelumLunas = Denda::where('status', 'belum lunas')
            ->with(['peminjaman.anggota', 'peminjaman.buku'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Pastikan Anda punya view 'fines.admin'
        // Jika belum ada, buat file resources/views/fines/admin.blade.php
        return view('fines.admin', compact('dendaBelumLunas'));
    }

    /**
     * Proses Pembayaran Manual oleh Admin (Cash di perpustakaan)
     */
    public function prosesPembayaran($id)
    {
        $denda = Denda::find($id);

        if (!$denda || $denda->status == 'lunas') {
            return back()->with('error', 'Denda tidak ditemukan atau sudah lunas.');
        }

        try {
            $denda->update([
                'status' => 'lunas',
                'tanggal_pembayaran' => now(),
            ]);

            return back()->with('success', 'Pembayaran denda berhasil dicatat.');
        } catch (\Exception $e) {
            Log::error('Error bayar denda: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran.');
        }
    }

    // Hapus denda (jika perlu)
    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();
        return back()->with('success', 'Data denda dihapus.');
    }
}
