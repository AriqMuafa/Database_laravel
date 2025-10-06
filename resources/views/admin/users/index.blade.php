<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full border-collapse text-sm text-left text-gray-500 dark:text-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 border dark:border-gray-600">Nama</th>
                                <th scope="col" class="px-6 py-3 border dark:border-gray-600">Email</th>
                                <th scope="col" class="px-6 py-3 border dark:border-gray-600">Role</th>
                                <th scope="col" class="px-6 py-3 border dark:border-gray-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    {{-- PERUBAHAN: Menghapus kelas 'text-gray-900' dari baris ini --}}
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white border dark:border-gray-700">
                                        {{ $user->name }}
                                    </th>
                                    <td class="px-6 py-4 border dark:border-gray-700">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 border dark:border-gray-700">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-900 text-blue-200">
                                            {{ $user->role?->display_name ?? 'Tanpa Role' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right border dark:border-gray-700 space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                        class="font-medium text-blue-400 hover:underline">
                                        Edit
                                        </a>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                            method="POST" 
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="font-medium text-red-400 hover:underline"
                                                    onclick="return confirm('Yakin mau hapus user ini?')">
                                                Delete
                                            </button>
                                        </form>

                                        {{-- Tombol Add (tambah user baru) --}}
                                        <a href="{{ route('users.create') }}" 
                                        class="font-medium text-green-400 hover:underline">
                                        Add
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-800">
                                    <td colspan="4" class="px-6 py-4 text-center border dark:border-gray-700">
                                        Tidak ada data pengguna.
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