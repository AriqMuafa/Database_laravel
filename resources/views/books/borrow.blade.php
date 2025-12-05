<x-app-layout>
    {{-- Bagian Header Halaman (Tidak Berubah) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    {{-- Latar belakang abu-abu muda ditambahkan --}}
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol "Transaksi Baru" dipindah ke luar kontainer putih dan diberi style baru --}}
            <div class="mb-4">
                <a href="{{ route('peminjaman.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + Transaksi Baru
                </a>
            </div>

            {{-- Kontainer Putih Utama (Menghapus kelas 'dark:') --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Pesan sukses (dipindah ke dalam kontainer putih agar rapi) --}}
                @if (session('success'))
                    <div class="p-6 border-b border-gray-200">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                {{-- Tabel Data Peminjaman (tanpa div p-6 agar tabel 'full-width') --}}
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500">
                        {{-- Header Tabel diganti dari hijau menjadi abu-abu muda --}}
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                {{-- Semua Kolom dan Teks SAMA PERSIS seperti kode asli --}}
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
                            {{-- Variabel $data_peminjaman dan $pinjam TIDAK DIUBAH --}}
                            @forelse ($data_peminjaman as $pinjam)
                                {{-- Kelas 'dark:' dihapus dari <tr> --}}
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6">{{ $pinjam->peminjaman_id }}</td>

                                    {{-- Data Anggota --}}
                                    <td class="py-4 px-6">{{ $pinjam->anggota->anggota_id }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $pinjam->anggota->nama }}
                                    </td>

                                    {{-- Data Buku --}}
                                    <td class="py-4 px-6">{{ $pinjam->buku->buku_id }}</td>
                                    <td class="py-4 px-6">{{ $pinjam->buku->judul }}</td>

                                    <td class="py-4 px-6">{{ $pinjam->tanggal_pinjam }}</td>
                                    <td class="py-4 px-6">{{ $pinjam->tanggal_jatuh_tempo }}</td>

                                    {{-- Denda (hanya menghapus kelas 'dark:') --}}
                                    <td class="py-4 px-6 font-medium whitespace-nowrap
                                        @if ($pinjam->denda_saat_ini > 0)
                                            text-red-500
                                        @else
                                            text-gray-900
                                        @endif">
                                        Rp {{ number_format($pinjam->denda_saat_ini, 0, ',', '.') }}
                                    </td>

                                    {{-- Status (Tidak Berubah) --}}
                                    <td class="py-4 px-6">
                                        @if ($pinjam->status == 'sudah dikembalikan')
                                            <span class="text-green-600 font-semibold">Sudah Dikembalikan</span>
                                        @elseif ($pinjam->status == 'dipinjam')
                                            <span class="text-yellow-600 font-semibold">Dipinjam</span>
                                        @else
                                            <span class="text-gray-500 italic">Tidak Diketahui</span>
                                        @endif
                                    </td>

                                    {{-- Tombol (Tidak Berubah) --}}
                                    <td class="py-4 px-6">
                                        <a href="{{ route('peminjaman.cetak', $pinjam) }}" target="_blank"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs">
                                            Bayar Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                {{-- Kelas 'dark:' dihapus --}}
                                <tr class="bg-white border-b">
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
</x-app-layout>