<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Denda Perpustakaan</title>
    <!-- Tailwind CSS CDN untuk styling yang rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
        .card { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); }
        .table-header { background-color: #eef2ff; } /* Indigo light background */
    </style>
</head>
<body class="p-4 sm:p-8">

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 border-b-4 border-indigo-600 pb-2">
            💰 Kelola Denda (Tunggakan Belum Lunas)
        </h1>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">SUKSES</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">ERROR</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <!-- Tabel Daftar Denda -->
        <div class="bg-white card rounded-xl overflow-hidden shadow-lg">
            @if ($dendaBelumLunas->isEmpty())
                <div class="p-10 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak Ada Data Denda</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Semua tagihan denda telah dilunasi, atau tidak ada peminjaman yang terlambat saat ini.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-header">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Denda</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Anggota</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Buku (ID Peminjaman)</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Denda</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($dendaBelumLunas as $denda)
                                @php
                                    // Ambil data dari relasi
                                    $peminjaman = $denda->peminjaman;
                                    $anggota = $peminjaman->anggota ?? null;
                                    $buku = $peminjaman->buku ?? null;
                                    $tanggalJatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
                                @endphp
                                <tr class="hover:bg-indigo-50/50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-indigo-700">
                                        {{ $denda->denda_id }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $anggota->nama ?? 'N/A' }} 
                                        <span class="text-xs text-gray-500 block">(Anggota ID: {{ $peminjaman->anggota_id ?? 'N/A' }})</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $buku->judul ?? 'N/A' }} 
                                        <span class="text-xs text-gray-500 block">(Pinjam ID: {{ $peminjaman->peminjaman_id }})</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tanggalJatuhTempo->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-lg font-extrabold text-red-600">
                                        Rp {{ number_format($denda->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium text-center">
                                        <!-- Formulir untuk Aksi Pembayaran -->
                                        <!-- Menggunakan route baru: fines.bayar -->
                                        <form action="{{ route('fines.bayar', $denda->denda_id) }}" method="POST" 
                                            onsubmit="return confirm('KONFIRMASI PEMBAYARAN: Apakah Anggota sudah membayar denda Rp {{ number_format($denda->jumlah, 0, ',', '.') }}? Aksi ini akan melunasi tagihan.');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full 
                                                shadow-lg transition duration-200 ease-in-out transform hover:scale-105 active:scale-95 text-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.618a8 8 0 11-12.834 8.636 8 8 0 0112.834-8.636z"></path></svg>
                                                Catat Lunas
                                            </button>
                                        </form>
                                    </td>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>