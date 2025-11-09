{{-- 
CATATAN:
File ini mengasumsikan Anda menggunakan layout standar Laravel Breeze/Jetstream
yang menggunakan Tailwind CSS dan memiliki dark mode.
--}}
<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Tombol Transaksi Baru --}}
                    <a href="{{ route('peminjaman.create') }}"
                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mb-4">
                        Transaksi Baru
                    </a>

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel Data Peminjaman --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-white uppercase bg-green-600 dark:bg-green-700">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">ID Transaksi</th>
                                    <th scope="col" class="py-3 px-6">ID Anggota</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">ID Buku</th>
                                    <th scope="col" class="py-3 px-6">Judul Buku</th>
                                    <th scope="col" class="py-3 px-6">Tanggal Pinjam</th>
                                    <th scope="col" class="py-3 px-6">Jatuh Tempo</th>
                                    <th scope="col" class="py-3 px-6">Denda Saat Ini</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data_peminjaman as $pinjam)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6">{{ $pinjam->peminjaman_id }}</td>

                                        {{-- Data Anggota --}}
                                        <td class="py-4 px-6">{{ $pinjam->anggota->anggota_id }}</td>
                                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $pinjam->anggota->nama }}
                                        </td>

                                        {{-- Data Buku --}}
                                        <td class="py-4 px-6">{{ $pinjam->buku->buku_id }}</td>
                                        <td class="py-4 px-6">{{ $pinjam->buku->judul }}</td>

                                        <td class="py-4 px-6">{{ $pinjam->tanggal_pinjam }}</td>
                                        <td class="py-4 px-6">{{ $pinjam->tanggal_jatuh_tempo }}</td>

                                        {{-- Denda --}}
                                        <td class="py-4 px-6 font-medium whitespace-nowrap
                                            @if ($pinjam->denda_saat_ini > 0)
                                                text-red-500 dark:text-red-400
                                            @else
                                                text-gray-900 dark:text-white
                                            @endif">
                                            Rp {{ number_format($pinjam->denda_saat_ini, 0, ',', '.') }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="py-4 px-6">
                                            @if ($pinjam->status == 'sudah dikembalikan')
                                                <span class="text-green-600 font-semibold">Sudah Dikembalikan</span>
                                            @elseif ($pinjam->status == 'dipinjam')
                                                <span class="text-yellow-600 font-semibold">Dipinjam</span>
                                            @else
                                                <span class="text-gray-500 italic">Tidak Diketahui</span>
                                            @endif
                                        </td>

                                        {{-- Tombol Cetak Nota --}}
                                        <td class="py-4 px-6">
                                            <a href="{{ route('peminjaman.cetak', $pinjam) }}" target="_blank"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                Bayar Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="11" class="py-4 px-6 text-center">
                                            Belum ada data peminjaman aktif.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
