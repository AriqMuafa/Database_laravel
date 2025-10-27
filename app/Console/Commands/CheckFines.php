<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman; // <-- Import
use App\Models\Denda;      // <-- Import
use Carbon\Carbon;         // <-- Import

class CheckFines extends Command
{
    /**
     * The name and signature of the console command.
     * Nama perintah yang akan kita panggil: php artisan check:fines
     * @var string
     */
    protected $signature = 'check:fines';

    /**
     * The console command description.
     * Deskripsi perintah ini.
     * @var string
     */
    protected $description = 'Periksa peminjaman yang terlambat dan catat/update denda harian';

    /**
     * Execute the console command.
     * Logika utama yang akan dijalankan.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan denda...'); // Pesan di terminal

        $tarif_denda_per_hari = 1000; // Tarif denda Anda
        $hari_ini = now()->startOfDay();
        $denda_dicatat = 0;
        $denda_diupdate = 0;

        // 1. Ambil semua peminjaman yang BELUM dikembalikan DAN sudah lewat jatuh tempo
        $peminjaman_terlambat = Peminjaman::whereNull('tanggal_pengembalian')
                                    ->whereDate('tanggal_jatuh_tempo', '<', $hari_ini)
                                    ->get();

        if ($peminjaman_terlambat->isEmpty()) {
            $this->info('Tidak ada peminjaman yang terlambat hari ini.');
            return 0; // Selesai
        }

        $this->info('Ditemukan ' . $peminjaman_terlambat->count() . ' peminjaman terlambat. Memproses...');

        // 2. Loop setiap peminjaman yang terlambat
        foreach ($peminjaman_terlambat as $pinjam) {
            try {
                $jatuh_tempo = Carbon::parse($pinjam->tanggal_jatuh_tempo)->startOfDay();

                // Hitung denda terbaru
                $hari_terlambat = max(0, $jatuh_tempo->diffInDays($hari_ini, false));
                $total_denda = $hari_terlambat * $tarif_denda_per_hari;

                // 3. Gunakan updateOrCreate untuk mencatat atau memperbarui denda
                // - Cari denda berdasarkan peminjaman_id
                // - Jika tidak ada, buat baru
                // - Jika ada, update jumlahnya
                $denda = Denda::updateOrCreate(
                    ['peminjaman_id' => $pinjam->peminjaman_id], // Kunci pencarian
                    [
                        'jumlah' => $total_denda,                 // Nilai yang diisi/diupdate
                        'status' => 'belum lunas'               // Status (diupdate juga jika perlu)
                    ]
                );

                // Cek apakah record baru dibuat atau diupdate untuk statistik
                if ($denda->wasRecentlyCreated) {
                    $denda_dicatat++;
                } elseif ($denda->wasChanged('jumlah')) { // Cek jika kolom 'jumlah' berubah
                    $denda_diupdate++;
                }

            } catch (\Exception $e) {
                // Catat error jika ada masalah dengan satu peminjaman
                $this->error('Error memproses peminjaman ID ' . $pinjam->peminjaman_id . ': ' . $e->getMessage());
                // Lanjutkan ke peminjaman berikutnya
                continue;
            }
        }

        $this->info('Pengecekan denda selesai.');
        $this->info("Denda baru dicatat: " . $denda_dicatat);
        $this->info("Denda diperbarui: " . $denda_diupdate);

        return 0; // Sukses
    }
}