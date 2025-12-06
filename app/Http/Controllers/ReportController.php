<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Menampilkan daftar transaksi yang difilter berdasarkan bulan dan tahun.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi variabel default
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // 2. Inisialisasi variabel yang akan dikirim ke View (agar tidak Undefined)
        $peminjaman = collect();
        $availableDates = collect();
        $reportTitle = 'Laporan Gagal Dimuat';
        
        try {
            // Tentukan tanggal awal dan akhir bulan yang dipilih
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month)->endOfMonth()->endOfDay();

            // Ambil data peminjaman
            $peminjaman = Peminjaman::with(['buku', 'anggota'])
                ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
                ->latest('tanggal_pinjam')
                ->get();
            
            $reportTitle = 'Laporan Transaksi Bulan ' . Carbon::createFromDate($year, $month)->isoFormat('MMMM YYYY');

            // Ambil tanggal yang tersedia untuk filter dropdown
            $availableDates = Peminjaman::select(
                DB::raw('YEAR(tanggal_pinjam) as year'), 
                DB::raw('MONTH(tanggal_pinjam) as month')
            )
            ->distinct()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        } catch (\Exception $e) {
            // Jika ada error (misal: koneksi DB), semua variabel default di atas akan digunakan
            session()->flash('error', 'Gagal memuat data laporan: ' . $e->getMessage());
        }

        // 3. Mengirim semua variabel yang telah diinisialisasi ke View
        return view('admin.reports', compact( 
            'peminjaman', 
            'reportTitle', 
            'availableDates', 
            'month', 
            'year'
        ));
    }
}