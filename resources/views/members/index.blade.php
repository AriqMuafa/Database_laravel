{{-- resources/views/members/index.blade.php --}}
<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Kontainer Tabel agar bisa scroll horizontal di HP --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            {{-- Header Tabel --}}
                            <thead class="text-xs text-white uppercase bg-green-600 dark:bg-green-700">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">ID Anggota</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Alamat</th>
                                    <th scope="col" class="py-3 px-6">Telepon</th>
                                    <th scope="col" class="py-3 px-6">Total Peminjaman</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>

                            {{-- Isi Tabel --}}
                            <tbody>
                                @forelse ($anggota as $a)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6">{{ $a->anggota_id }}</td>
                                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $a->nama }}
                                        </td>
                                        <td class="py-4 px-6">{{ $a->alamat }}</td>
                                        <td class="py-4 px-6">{{ $a->telepon }}</td>
                                        <td class="py-4 px-6">{{ $a->peminjaman_count }}</td>

                                        {{-- Tombol Lihat Peminjaman --}}
                                        <td class="py-4 px-6">
                                            <a href="{{ route('members.detail', $a->anggota_id) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                Lihat Peminjaman
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="7" class="py-4 px-6 text-center">
                                            Belum ada data anggota.
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
