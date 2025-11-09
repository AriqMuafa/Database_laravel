<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Peminjaman Anggota: ') }} {{ $anggota->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pesan sukses jika berhasil mengembalikan buku --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Info Anggota --}}
                    <div class="mb-6">
                        <p><strong>ID Anggota:</strong> {{ $anggota->anggota_id }}</p>
                        <p><strong>Alamat:</strong> {{ $anggota->alamat }}</p>
                        <p><strong>Telepon:</strong> {{ $anggota->telepon }}</p>
                    </div>

                    {{-- Tabel Peminjaman --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            {{-- Header --}}
                            <thead class="text-xs text-white uppercase bg-green-600 dark:bg-green-700">
                                <tr>
                                    <th class="py-3 px-6">No</th>
                                    <th class="py-3 px-6">ID Transaksi</th>
                                    <th class="py-3 px-6">Judul Buku</th>
                                    <th class="py-3 px-6">Tanggal Pinjam</th>
                                    <th class="py-3 px-6">Jatuh Tempo</th>
                                    <th class="py-3 px-6">Tanggal Pengembalian</th>
                                    <th class="py-3 px-6">Denda</th>
                                    <th class="py-3 px-6">Status Denda</th>
                                    <th class="py-3 px-6">Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($peminjaman as $pinjam)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6">{{ $pinjam->peminjaman_id }}</td>
                                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">
                                            {{ $pinjam->buku->judul }}
                                        </td>
                                        <td class="py-4 px-6">{{ $pinjam->tanggal_pinjam }}</td>
                                        <td class="py-4 px-6">{{ $pinjam->tanggal_jatuh_tempo }}</td>
                                        <td class="py-4 px-6">
                                            {{ $pinjam->tanggal_pengembalian ?? '-' }}
                                        </td>

                                        {{-- Denda --}}
                                        <td class="py-4 px-6 
                                            @if(optional($pinjam->denda)->jumlah > 0) text-red-500 font-semibold @endif">
                                            Rp {{ number_format(optional($pinjam->denda)->jumlah ?? 0, 0, ',', '.') }}
                                        </td>

                                        {{-- Status Denda --}}
                                        <td class="py-4 px-6">
                                            @if($pinjam->denda)
                                                <span class="px-2 py-1 rounded text-xs 
                                                    {{ $pinjam->denda->status == 'lunas' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                    {{ ucfirst($pinjam->denda->status) }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 rounded text-xs bg-gray-400 text-white">Tidak Ada</span>
                                            @endif
                                        </td>

                                        {{-- Tombol Pengembalian --}}
                                        <td class="py-4 px-6">
                                            @if(!$pinjam->tanggal_pengembalian)
                                                <form action="{{ route('peminjaman.kembali', $pinjam) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                                    @csrf
                                                    <button type="submit"
                                                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-green-500 font-semibold text-xs">Sudah dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-4 px-6 text-center">
                                            Belum ada data peminjaman untuk anggota ini.
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
