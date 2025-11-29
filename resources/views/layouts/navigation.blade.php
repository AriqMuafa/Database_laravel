<nav x-data="{ open: false }" class="bg-blue-400 border-b border-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('img/digilib.svg') }}" class="w-9 h-9" alt="Logo">
                    <span class="font-bold text-xl text-white">DigiLib</span>
                </a>
            </div>

            {{-- NAV LINKS DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">

                <a href="{{ route('dashboard') }}"
                    class="text-white hover:text-gray-200 font-medium {{ request()->routeIs('dashboard') ? 'underline' : '' }}">
                    Home
                </a>

                <a href="{{ route('menu.buku') }}"
                    class="text-white hover:text-gray-200 font-medium {{ request()->routeIs('menu.buku') ? 'underline' : '' }}">
                    Books
                </a>

                <a href="{{ route('about') }}"
                    class="text-white hover:text-gray-200 font-medium {{ request()->routeIs('about') ? 'underline' : '' }}">
                    About Us
                </a>

                <a href="{{ route('contact') }}"
                    class="text-white hover:text-gray-200 font-medium {{ request()->routeIs('contact') ? 'underline' : '' }}">
                    Contact
                </a>

            </div>

            {{-- USER DROPDOWN --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 text-white">

                            {{-- Avatar --}}
                            <div class="w-9 h-9 rounded-full bg-white/20 border border-white/40 
                                text-white flex items-center justify-center font-bold backdrop-blur">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <span>{{ Auth::user()->name }}</span>

                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('menu.peminjaman')">
                            Peminjaman Saya
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>
            </div>

            {{-- HAMBURGER MOBILE --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-white hover:bg-blue-500 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-blue-600 px-4 pt-3 pb-4">

        <a href="{{ route('dashboard') }}"
            class="block py-2 text-white {{ request()->routeIs('dashboard') ? 'underline' : '' }}">
            Home
        </a>

        <a href="{{ route('menu.buku') }}"
            class="block py-2 text-white {{ request()->routeIs('menu.buku') ? 'underline' : '' }}">
            Books
        </a>

        <a href="#" class="block py-2 text-white">About Us</a>
        <a href="#" class="block py-2 text-white">Contact</a>

        <div class="border-t border-blue-400 mt-3 pt-3 text-white">
            <div class="font-bold">{{ Auth::user()->name }}</div>
            <div class="text-blue-200 text-sm">{{ Auth::user()->email }}</div>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button class="text-red-200 hover:text-red-100 text-left w-full">
                    Log Out
                </button>
            </form>
        </div>

    </div>
</nav>