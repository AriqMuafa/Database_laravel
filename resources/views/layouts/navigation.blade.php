<nav x-data="{ open: false }" class="bg-[#4C72AF] relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    {{-- Pastikan file gambar ada di public/img/digilib.svg --}}
                    <img src="{{ asset('img/digilib.svg') }}" class="w-9 h-9" alt="Logo">
                    <span class="font-bold text-xl text-white">DigiLib</span>
                </a>
            </div>

            {{-- NAV LINKS DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">

                <a href="{{ route('dashboard') }}"
                    class="text-white hover:text-blue-200 px-3 py-2 rounded-md font-medium text-sm transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-[#6187B7]' : '' }}">
                    Home
                </a>

                {{-- Menambahkan 'books.*' agar menu tetap aktif saat membuka detail buku --}}
                <a href="{{ route('books.index') }}"
                    class="text-white hover:text-blue-200 px-3 py-2 rounded-md font-medium text-sm transition duration-150 ease-in-out {{ request()->routeIs('menu.buku', 'books.*') ? 'bg-blue-700' : '' }}">
                    Books
                </a>

                <a href="{{ route('about') }}"
                    class="text-white hover:text-blue-200 px-3 py-2 rounded-md font-medium text-sm transition duration-150 ease-in-out {{ request()->routeIs('about') ? 'bg-blue-700' : '' }}">
                    About Us
                </a>

                <a href="{{ route('contact') }}"
                    class="text-white hover:text-blue-200 px-3 py-2 rounded-md font-medium text-sm transition duration-150 ease-in-out {{ request()->routeIs('contact') ? 'bg-blue-700' : '' }}">
                    Contact Us
                </a>

            </div>

            {{-- USER DROPDOWN --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center space-x-2 text-white hover:text-blue-200 focus:outline-none transition duration-150 ease-in-out">
                            {{-- Avatar Inisial --}}
                            <div
                                class="w-8 h-8 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold text-sm border-2 border-transparent hover:border-blue-200">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>

                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('menu.peminjaman')">
                            {{ __('Peminjaman Saya') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600 hover:text-red-800">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            {{-- HAMBURGER MENU (MOBILE) --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-blue-500 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU RESPONSIVE --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-blue-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Home') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('menu.buku')" :active="request()->routeIs('menu.buku', 'books.*')" class="text-white">
                {{ __('Books') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" class="text-white">
                {{ __('About Us') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" class="text-white">
                {{ __('Contact Us') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-blue-500">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-blue-100 hover:text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('menu.peminjaman')" class="text-blue-100 hover:text-white">
                    {{ __('Peminjaman Saya') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-300 hover:text-red-100">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
