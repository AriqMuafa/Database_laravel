<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Nama</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Role</label>
                            <select name="role_id" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="flex justify-end">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg mr-2">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
