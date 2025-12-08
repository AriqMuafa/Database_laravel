<x-app-layout>
    {{-- Background Abu-abu Halus --}}
    <div class="py-12 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb / Back Button --}}
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('books.index') }}"
                            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Katalog Buku
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-slate-800 md:ml-2 line-clamp-1">{{ $book->judul }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- KARTU UTAMA --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <div class="flex flex-col lg:flex-row gap-12">

                        {{-- KOLOM KIRI: Cover Buku --}}
                        <div class="flex-shrink-0 mx-auto lg:mx-0 w-full max-w-[280px]">
                            <div class="relative group rounded-2xl shadow-2xl overflow-hidden aspect-[2/3]">
                                {{-- Gambar --}}
                                <img src="{{ $book->cover ? asset('storage/covers/' . $book->cover) : 'https://via.placeholder.com/300x450' }}"
                                    alt="{{ $book->judul }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                                {{-- Overlay Gradient --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>

                            {{-- Status Stok (Mobile: Hidden, Desktop: Shown below image) --}}
                            <div class="mt-6 text-center hidden lg:block">
                                @php
                                    $stokTersedia =
                                        $book->stok_buku -
                                        ($book->peminjaman->where('status', 'dipinjam')->count() ?? 0) -
                                        ($book->reservasi->where('status', 'menunggu')->count() ?? 0);
                                @endphp
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $stokTersedia > 0 ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' }}">
                                    <span class="relative flex h-2.5 w-2.5">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $stokTersedia > 0 ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
                                        <span
                                            class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $stokTersedia > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    </span>
                                    <span class="text-sm font-semibold">
                                        {{ $stokTersedia > 0 ? 'Stok Tersedia: ' . $stokTersedia : 'Stok Habis' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: Detail & Aksi --}}
                        <div class="flex-grow flex flex-col">

                            {{-- Header: Kategori & Rating --}}
                            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                                <span
                                    class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-100">
                                    {{ $book->kategori->nama_kategori ?? 'Umum' }}
                                </span>

                                {{-- Rating --}}
                                <div
                                    class="flex items-center gap-1 bg-yellow-50 px-3 py-1 rounded-full border border-yellow-100">
                                    @php $avgRating = $book->reviews->avg('rating') ?? 0; @endphp
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span
                                        class="text-sm font-bold text-slate-700">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-xs text-slate-400">({{ $book->reviews->count() }} ulasan)</span>
                                </div>
                            </div>

                            {{-- Judul & Penulis --}}
                            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight mb-2">
                                {{ $book->judul }}
                            </h1>
                            <p class="text-lg text-slate-500 font-medium mb-6 flex items-center gap-2">
                                <span>Oleh:</span>
                                <span class="text-slate-800">{{ $book->pengarang }}</span>
                            </p>

                            {{-- Metadata Badges (Modern) --}}
                            <div class="flex flex-wrap gap-3 mb-8">
                                <div
                                    class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span>{{ $book->penerbit }}</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>Tahun {{ $book->tahun_terbit }}</span>
                                </div>
                            </div>

                            {{-- Sinopsis --}}
                            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed mb-8">
                                <h3 class="text-sm font-bold uppercase text-slate-400 tracking-wider mb-2">Sinopsis</h3>
                                <p class="text-justify">
                                    {{ $book->sinopsis ?? 'Tidak ada deskripsi untuk buku ini.' }}
                                </p>
                            </div>

                            <div class="mt-auto pt-6 border-t border-slate-100">
                                {{-- TOMBOL AKSI --}}
                                <div class="flex flex-col sm:flex-row gap-4">

                                    {{-- 1. TOMBOL PINJAM --}}
                                    @guest
                                        <a href="{{ route('login') }}"
                                            onclick="return confirm('Login diperlukan untuk meminjam buku.')"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 transition-all shadow-sm">
                                            Pinjam Buku
                                        </a>
                                    @else
                                        @if ($stokTersedia > 0)
                                            <form action="{{ route('peminjaman.store') }}" method="POST"
                                                class="flex-1 w-full">
                                                @csrf
                                                <input type="hidden" name="buku_id" value="{{ $book->buku_id }}">
                                                <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                                <button type="submit" onclick="return confirm('Konfirmasi peminjaman?')"
                                                    class="w-full inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                                                    Pinjam Sekarang
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('reservasi.store', $book->buku_id) }}" method="POST"
                                                class="flex-1 w-full">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Stok habis. Masuk antrean reservasi?')"
                                                    class="w-full inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-amber-500 hover:bg-amber-600 shadow-lg hover:shadow-amber-500/30 transition-all transform hover:-translate-y-0.5">
                                                    Reservasi
                                                </button>
                                            </form>
                                        @endif
                                    @endguest

                                    {{-- 2. TOMBOL BACA DIGITAL --}}
                                    @if ($book->bukuDigital)
                                        @guest
                                            <a href="{{ route('login') }}"
                                                onclick="return confirm('Login diperlukan untuk membaca buku.')"
                                                class="flex-1 inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 transition-all shadow-sm">
                                                Baca Digital
                                            </a>
                                        @else
                                            <a href="{{ route('digital.show', $book->bukuDigital->buku_digital_id ?? $book->bukuDigital->id) }}"
                                                target="_blank"
                                                class="flex-1 inline-flex justify-center items-center gap-2 px-6 py-3.5 border border-slate-200 text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                Baca Digital
                                            </a>
                                        @endguest
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: GRID BAWAH --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">

                {{-- KOLOM KIRI (2/3): Komentar --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                            Ulasan & Diskusi
                        </h3>

                        {{-- Form Komentar --}}
                        <div class="flex gap-4 mb-10">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg {{ Auth::check() ? 'bg-gradient-to-br from-indigo-500 to-purple-600' : 'bg-slate-200' }}">
                                    @auth
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @else
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    @endauth
                                </div>
                            </div>

                            <div class="flex-grow">
                                <form action="{{ route('reviews.store', $book->buku_id) }}" method="POST">
                                    @csrf
                                    <textarea name="comment" rows="2"
                                        class="w-full border border-slate-200 rounded-xl p-4 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 resize-none transition-all placeholder-slate-400 text-slate-700 bg-slate-50 focus:bg-white"
                                        placeholder="Bagikan pendapat Anda tentang buku ini..."></textarea>

                                    <div class="flex justify-between items-center mt-3">
                                        {{-- Rating Stars --}}
                                        <div x-data="{ rating: 0, hoverRating: 0 }" class="flex space-x-1">
                                            <input type="hidden" name="rating" :value="rating">
                                            <template x-for="star in 5">
                                                <button type="button" @click="rating = star"
                                                    @mouseover="hoverRating = star" @mouseleave="hoverRating = 0"
                                                    class="focus:outline-none transition-transform hover:scale-110">
                                                    <svg class="w-6 h-6 transition-colors duration-150"
                                                        :class="{
                                                            'text-slate-200': !(hoverRating >= star || (!hoverRating &&
                                                                rating >= star)),
                                                            'text-yellow-400': hoverRating >=
                                                                star || (!hoverRating && rating >= star)
                                                        }"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>

                                        @auth
                                            <button type="submit"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold shadow-sm transition text-sm">
                                                Kirim Ulasan
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" onclick="alert('Login diperlukan.')"
                                                class="bg-slate-200 hover:bg-slate-300 text-slate-600 px-6 py-2 rounded-lg font-semibold transition text-sm">
                                                Kirim Ulasan
                                            </a>
                                        @endauth
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Review List --}}
                        <div class="space-y-8">
                            @forelse($book->reviews as $review)
                                <div class="flex gap-4 pb-6 border-b border-slate-50 last:border-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $review->user->name }}
                                            </h4>
                                            <span
                                                class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex text-yellow-400 text-xs mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    ★
                                                @else
                                                    <span class="text-slate-200">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400">
                                    <p>Belum ada ulasan. Jadilah yang pertama mereview!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (1/3): Buku Relevan --}}
                <div>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sticky top-24">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-6 w-1 bg-indigo-500 rounded-full"></div>
                            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wide">Buku Terkait</h3>
                        </div>

                        <div class="flex flex-col gap-4">
                            @foreach ($relatedBooks as $related)
                                <a href="{{ route('books.show', $related->buku_id) }}"
                                    class="group flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 transition-all duration-300">

                                    {{-- Thumbnail --}}
                                    <div class="flex-shrink-0 w-16 h-24 rounded-lg overflow-hidden shadow-sm relative">
                                        <img src="{{ $related->cover ? asset('storage/' . $related->cover) : 'https://via.placeholder.com/150x225' }}"
                                            alt="{{ $related->judul }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>

                                    {{-- Detail --}}
                                    <div class="flex-grow flex flex-col justify-between h-24 py-0.5">
                                        <div>
                                            <span
                                                class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider mb-1 block">
                                                {{ $related->kategori->nama_kategori ?? 'Umum' }}
                                            </span>
                                            <h4 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors"
                                                title="{{ $related->judul }}">
                                                {{ $related->judul }}
                                            </h4>
                                        </div>
                                        <div
                                            class="flex items-center text-xs font-medium text-slate-400 group-hover:text-indigo-500 transition-colors">
                                            <span>Lihat Detail</span>
                                            <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
