<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with(['peminjaman.buku', 'peminjaman.denda'])->get();
        return view('pengembalian.index', compact('anggota'));
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('denda')->findOrFail($id);
        $peminjaman->tanggal_pengembalian = Carbon::now();
        $peminjaman->status = 'sudah dikembalikan';
        $peminjaman->save();

        if ($peminjaman->denda && $peminjaman->denda->jumlah == 0) {
            $peminjaman->denda->update(['status' => 'lunas']);
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
}

