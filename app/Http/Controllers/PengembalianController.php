<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($peminjaman->status == 'sudah dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $tanggal_kembali = Carbon::now();
            $jatuh_tempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            // 1. Hitung Denda Final
            $jumlah_denda = 0;
            if ($tanggal_kembali->gt($jatuh_tempo)) {
                $selisih_hari = $tanggal_kembali->diffInDays($jatuh_tempo);
                $tarif_per_hari = 1000;
                $jumlah_denda = $selisih_hari * $tarif_per_hari;
            }

            // 2. Buat Tagihan Denda jika ada
            if ($jumlah_denda > 0) {
                Denda::create([
                    'peminjaman_id' => $peminjaman->peminjaman_id, // Primary Key tabel peminjaman
                    'jumlah' => $jumlah_denda,
                    'status' => 'belum lunas'
                ]);
            }

            // 3. Update Status Peminjaman
            $peminjaman->update([
                'status' => 'sudah dikembalikan',
                'tanggal_pengembalian' => $tanggal_kembali,
            ]);

            // 4. Stok Bertambah
            if ($peminjaman->buku) {
                $peminjaman->buku->increment('stok_buku');
            }

            DB::commit();

            $msg = 'Buku berhasil dikembalikan.';
            if ($jumlah_denda > 0) {
                $msg .= ' Terlambat ' . $selisih_hari . ' hari. Denda: Rp ' . number_format($jumlah_denda);
            }

            return back()->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
