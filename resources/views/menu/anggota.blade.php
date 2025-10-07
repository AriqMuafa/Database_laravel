<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Kelola Anggota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <ul class="list-disc ml-6 space-y-3">
                    @if(auth()->user()->hasPermission('view_members'))
                        <li>
                            <a href="{{ route('members.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Lihat Daftar Anggota
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_expired_members'))
                        <li>
                            <a href="{{ route('admin.expired') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola Anggota Kadaluarsa
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
