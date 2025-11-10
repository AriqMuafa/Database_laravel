{{--  <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('menu.peminjaman')">
                            {{ __('Peminjaman Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>  --}}

{{-- Hapus semua kode lama di file ini dan ganti dengan ini --}}
<nav x-data="{ open: false }" class="navbar">
    <div class="navbar-container">

        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" class="logo"
                style="text-decoration: none; display: flex; align-items: center;">
                {{-- Ganti 'images/logo.svg' dengan path logo Anda di folder 'public' --}}
                <img src="{{ asset('img/digilib.svg') }}" alt="DigiLib Logo" class="logo-icon">

                {{-- 
                    PERHATIKAN: CSS Anda di .logo punya 'flex-direction: column', 
                    tapi gambar Anda 'row' (menyamping).
                    Saya tambahkan style 'display: flex' di atas agar cocok gambar.
                    Anda bisa hapus style inline itu jika sudah memperbaiki CSS-nya.
                --}}
            </a>
        </div>

        <div class="nav-links">
            {{-- 
                Ganti route('home') dll dengan nama route Anda yang sebenarnya.c 
                Class 'active' akan otomatis ditambahkan jika route-nya cocok.
            --}}
            <div class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">Home</a>
            </div>
            <div class="divider">|</div>
            <div class="nav-link {{ request()->routeIs('books.*', 'menu.buku') ? 'active' : '' }}">
                <a href="{{ route('menu.buku') }}">Book</a>
            </div>
            <div class="divider">|</div>
            <div class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <a href="#">About Us</a>
            </div>
            <div class="divider">|</div>
            <div class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <a href="#">Contact Us</a>
            </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="64">
                {{-- Ini adalah Pemicu Dropdown (Nama, Avatar, Panah) --}}
                <x-slot name="trigger">
                    <button class="user-profile" style="background: none; border: none; cursor: pointer;">
                        {{-- Panah Dropdown --}}
                        <div class="ms-1" style="color: white;">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="user-name">
                            {{ Auth::user()->name }}
                        </div>

                        {{-- Avatar --}}
                        <div class="user-avatar">
                            {{-- Anda bisa isi dengan inisial nama atau gambar --}}
                            {{-- <img src="..." /> --}}
                        </div>
                    </button>
                </x-slot>

                {{-- Ini adalah Konten Dropdown (Menu yang muncul) --}}
                <x-slot name="content">
                    <div
                        style="padding: 10px 15px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; background-color: #f9f9f9;">
                        <div class="user-avatar" style="width: 40px; height: 40px;">
                            {{-- Avatar kecil di dalam dropdown --}}
                        </div>
                        <div>
                            <div style="font-weight: bold;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.875rem; color: #6B7280;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    {{-- Link Profile (Ganti ke route profile Anda) --}}
                    <x-dropdown-link :href="route('profile.edit')">
                        <i class="fas fa-user" style="margin-right: 8px;"></i> {{-- Contoh ikon --}}
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    {{-- Link Peminjaman (Buat route-nya) --}}
                    <x-dropdown-link href="#">
                        <i class="fas fa-book" style="margin-right: 8px;"></i> {{-- Contoh ikon --}}
                        {{ __('Peminjaman') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();"
                            style="color: #EF4444;"> {{-- Warna merah --}}
                            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> {{-- Contoh ikon --}}
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        {{-- Ini adalah Hamburger Menu untuk Mobile (Anda bisa styling nanti) --}}
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Ini adalah Konten Dropdown Mobile (Anda bisa styling nanti) --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- INI PERBAIKANNYA --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            {{-- Tambahkan link mobile lainnya di sini --}}
        </div>
    </div>
</nav>
