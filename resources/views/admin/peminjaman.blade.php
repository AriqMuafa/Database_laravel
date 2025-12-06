<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Peminjaman (Admin/Pustakawan)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER: Tombol & Status --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

                {{-- Tombol Transaksi Baru (Input Manual oleh Petugas) --}}
                <a href="{{ route('peminjaman.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Transaksi Baru
                </a>

                {{-- Badge Indikator --}}
                <span
                    class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full border border-purple-200 shadow-sm">
                    Mode Petugas
                </span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">

                {{-- Notifikasi Sukses/Error --}}
                @if (session('success'))
                    <div class="p-4 bg-green-50 border-b border-green-100 text-green-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 bg-red-50 border-b border-red-100 text-red-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        {{-- Header Tabel --}}
                        <thead class="text-xs text-gray-700 uppercase bg-slate-200">
                            <tr>
                                <th class="py-3 px-6">No</th>
                                {{-- Kolom Peminjam WAJIB ADA untuk Admin --}}
                                <th class="py-3 px-6">Peminjam</th>
                                <th class="py-3 px-6">Buku</th>
                                <th class="py-3 px-6">Tgl Pinjam</th>
                                <th class="py-3 px-6">Jatuh Tempo</th>
                                <th class="py-3 px-6 text-center">Denda</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($data_peminjaman as $pinjam)
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="py-4 px-6">{{ $loop->iteration }}</td>

                                    {{-- Data Peminjam --}}
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-900">
                                            {{ $pinjam->anggota->nama ?? 'User Terhapus' }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            ID: {{ $pinjam->anggota->anggota_id ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Data Buku --}}
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">
                                            {{ $pinjam->buku->judul ?? 'Buku Terhapus' }}
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $pinjam->id_peminjaman }}</div>
                                    </td>

                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                    </td>

                                    {{-- Jatuh Tempo (Merah jika telat) --}}
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @php
                                            $jatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                                            $isOverdue = now()->gt($jatuhTempo) && $pinjam->status == 'dipinjam';
                                        @endphp
                                        <span class="{{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                            {{ $jatuhTempo->format('d M Y') }}
                                        </span>
                                        @if ($isOverdue)
                                            <span class="text-[10px] text-red-500 block font-semibold">Terlambat!</span>
                                        @endif
                                    </td>

                                    {{-- Denda --}}
                                    <td class="py-4 px-6 text-center">
                                        @if ($pinjam->denda_saat_ini > 0 || ($pinjam->denda && $pinjam->denda->jumlah > 0))
                                            @php
                                                $nominal = $pinjam->denda
                                                    ? $pinjam->denda->jumlah
                                                    : $pinjam->denda_saat_ini;
                                                $statusLunas = $pinjam->denda && $pinjam->denda->status == 'lunas';
                                            @endphp

                                            <span
                                                class="inline-block {{ $statusLunas ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-semibold px-2.5 py-0.5 rounded">
                                                Rp {{ number_format($nominal, 0, ',', '.') }}
                                                {{ $statusLunas ? '(Lunas)' : '' }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-6 text-center">
                                        @if ($pinjam->status == 'sudah dikembalikan')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-green-200">
                                                Dikembalikan
                                            </span>
                                        @elseif ($pinjam->status == 'dipinjam')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-yellow-200">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ ucfirst($pinjam->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi (KHUSUS ADMIN) --}}
                                    <td class="py-4 px-6 text-center">
                                        @if ($pinjam->status == 'dipinjam')
                                            {{-- Tombol Proses Kembali --}}
                                            <form action="{{ route('peminjaman.kembali', $pinjam->peminjaman_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Konfirmasi: Buku sudah diterima kembali dari anggota?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition shadow-sm w-full sm:w-auto">
                                                    Proses Kembali
                                                </button>
                                            </form>
                                        @else
                                            {{-- Tombol Cetak Bukti (Arsip) --}}
                                            <a href="{{ route('peminjaman.cetak', $pinjam->peminjaman_id) }}"
                                                target="_blank"
                                                class="text-blue-600 hover:text-blue-800 text-xs font-semibold hover:underline flex items-center justify-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Cetak Arsip
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-12 px-6 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-600">Belum ada data transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
