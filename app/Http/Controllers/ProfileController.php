<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
// Kita tidak memerlukan model 'Peminjaman' lagi di sini untuk sementara

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // ==================================================================
    // METODE YANG DIUBAH DENGAN DUMMY DATA
    // ==================================================================

    /**
     * Menampilkan halaman riwayat peminjaman user (dengan data palsu).
     */
    public function peminjaman(Request $request): View
    {
        // --- MULAI DUMMY DATA UNTUK HALAMAN PEMINJAMAN ---

        // 1. Peminjaman "Dikembalikan" (sesuai gambar)
        $peminjaman1 = new \stdClass();
        $peminjaman1->id = 1;
        $peminjaman1->buku = new \stdClass();
        $peminjaman1->buku->judul = 'Buku Sejarah Indonesia';
        $peminjaman1->tanggal_pinjam = '2025-10-10';
        $peminjaman1->tanggal_kembali = '2025-10-17';
        $peminjaman1->status = 'Dikembalikan';
        $peminjaman1->denda = null; // Tidak ada denda

        // 2. Peminjaman "Dipinjam" (sesuai gambar)
        $peminjaman2 = new \stdClass();
        $peminjaman2->id = 2;
        $peminjaman2->buku = new \stdClass();
        $peminjaman2->buku->judul = 'Novel Laskar Pelangi';
        $peminjaman2->tanggal_pinjam = '2025-10-12';
        $peminjaman2->tanggal_kembali = null; // Belum kembali
        $peminjaman2->status = 'Dipinjam';
        $peminjaman2->denda = null; // Tidak ada denda

        // 3. Peminjaman "Denda Belum Lunas" (untuk tombol 'Bayar Denda')
        $peminjaman3 = new \stdClass();
        $peminjaman3->id = 3; // ID ini yang akan dikirim ke halaman pembayaran
        $peminjaman3->buku = new \stdClass();
        $peminjaman3->buku->judul = 'Algoritma dan Pemrograman';
        $peminjaman3->tanggal_pinjam = '2025-10-15';
        $peminjaman3->tanggal_kembali = '2025-10-25'; // Sudah kembali (tapi telat)
        $peminjaman3->status = 'Dikembalikan'; // Status peminjaman sudah selesai
        
        $peminjaman3->denda = new \stdClass(); // Tapi ada denda
        $peminjaman3->denda->status_pembayaran = 'Belum Lunas';

        // Masukkan semua data palsu ke dalam collection
        $dummyPeminjamans = collect([$peminjaman1, $peminjaman2, $peminjaman3]);

        // --- AKHIR DUMMY DATA ---

        return view('profile.peminjaman', [
            'peminjamans' => $dummyPeminjamans,
        ]);
    }

    /**
     * Menampilkan halaman detail pembayaran denda (dengan data palsu).
     * Perhatikan: $id diterima tapi tidak digunakan, karena kita pakai data palsu.
     */
    public function pembayaranShow(Request $request, $id): View | RedirectResponse
    {
        // --- MULAI DUMMY DATA UNTUK HALAMAN PEMBAYARAN ---

        // 1. Buat data user palsu
        $dummyUser = new \stdClass();
        $dummyUser->name = 'Nama Anggota (Anda)'; // Sesuai gambar

        // 2. Buat data peminjaman palsu
        $dummyPeminjaman = new \stdClass();
        $dummyPeminjaman->buku = new \stdClass();
        $dummyPeminjaman->buku->judul = 'Algoritma dan Pemrograman'; // Sesuai data denda

        // 3. Buat data denda palsu
        $dummyDenda = new \stdClass();
        $dummyDenda->jumlah_denda = 5000; // Sesuai gambar
        $dummyDenda->status_pembayaran = 'Belum Lunas';

        // --- AKHIR DUMMY DATA ---
        
        return view('profile.pembayaran', [
            'peminjaman' => $dummyPeminjaman,
            'denda' => $dummyDenda,
            'user' => $dummyUser
        ]);
    }
}