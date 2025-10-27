<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    // Halaman utama "Peminjaman Saya"
    public function index()
    {
        $peminjaman = Peminjaman::with('denda')->get(); // Ambil semua peminjaman beserta denda
        return view('menu.peminjaman', compact('peminjaman'));
    }

    // Halaman daftar denda
    public function finesIndex(Request $request)
    {
        $dendaId = $request->query('denda'); // ambil ID dari query string ?denda=1
        $denda = Denda::with('peminjaman')->findOrFail($dendaId);

        return view('fines.index', compact('denda'));
    }
}
