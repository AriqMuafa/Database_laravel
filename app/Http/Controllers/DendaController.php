<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        // Ambil ID anggota yang sedang login
        $anggotaId = Auth::user()->anggota->anggota_id ?? null;

        if (!$anggotaId) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Ambil semua denda milik anggota yang login
        $denda = Denda::whereHas('peminjaman', function ($query) use ($anggotaId) {
            $query->where('anggota_id', $anggotaId);
        })->get();

        return view('menu.peminjaman', compact('denda'));
    }

    // Untuk admin
    public function adminIndex()
    {
        $denda = Denda::with('peminjaman')->get();
        return view('admin.denda.index', compact('denda'));
    }
}
