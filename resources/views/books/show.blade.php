<x-app-layout>
    {{-- Background Abu-abu Halus untuk Halaman --}}
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Tombol Kembali --}}
            <div class="mb-6">
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="font-medium">Kembali</span>
                </a>
            </div>

            {{-- KARTU UTAMA (Putih) --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm overflow-hidden p-8 sm:p-10">

                {{-- SECTION 1: DETAIL BUKU (Atas) --}}
                <div class="flex flex-col md:flex-row gap-10">

                    {{-- Kiri: Cover Buku (Ukuran A5: ~14.8 x 21cm) --}}
                    {{-- Kita set width fixed agar proporsional, height auto/aspect ratio --}}
                    <div class="flex-shrink-0 mx-auto md:mx-0">
                        <div class="w-[260px] h-auto shadow-xl rounded-lg overflow-hidden relative group">
                            {{-- Badge Special Offer (Opsional, sesuai gambar) --}}
                            <div
                                class="absolute top-4 -left-8 bg-yellow-400 text-red-600 font-bold text-xs py-1 px-10 -rotate-45 shadow-md z-10">
                                SPECIAL OFFER
                            </div>

                            {{-- Gambar Cover --}}
                            {{-- Ganti asset('storage/'. $book->cover) sesuai path penyimpananmu --}}
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/150x200' }}"
                                alt="{{ $book->judul }}" class="w-full h-auto object-cover rounded-md">
                        </div>
                    </div>

                    {{-- Kanan: Informasi Buku --}}
                    <div class="flex-grow">
                        {{-- Judul --}}
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                            {{ $book->judul }}
                        </h1>

                        {{-- Penulis --}}
                        <p class="text-lg text-gray-500 dark:text-gray-400 mb-4">
                            {{ $book->penulis }}
                        </p>

                        {{-- Rating Bintang (Rata-rata Static) --}}
                        <div class="flex items-center mb-6">
                            @php $avgRating = $book->reviews->avg('rating') ?? 0; @endphp
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5" fill="{{ $i <= round($avgRating) ? 'currentColor' : 'none' }}"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-400 text-sm">({{ number_format($avgRating, 1) }})</span>
                        </div>

                        {{-- Deskripsi/Sinopsis --}}
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-8 text-justify">
                            {{ $book->deskripsi ?? '"Dasar-dasar Pemrograman Web" adalah panduan komprehensif bagi pemula yang ingin menyelami dunia pengembangan web tanpa rasa takut...' }}
                        </p>

                        {{-- Metadata Tabel --}}
                        <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300 mb-8">
                            <div class="grid grid-cols-[140px_auto]">
                                <span class="font-bold uppercase text-gray-500">Penerbit</span>
                                <span>: {{ $book->penerbit }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_auto]">
                                <span class="font-bold uppercase text-gray-500">Tahun Terbit</span>
                                <span>: {{ $book->tahun_terbit }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_auto]">
                                <span class="font-bold uppercase text-gray-500">Kategori</span>
                                {{-- PERBAIKAN: Gunakan optional() atau cek null agar tidak error jika kategori dihapus --}}
                                <span>: {{ $book->kategori ? $book->kategori->nama_kategori : 'Umum' }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_auto]">
                                <span class="font-bold uppercase text-gray-500">Stok</span>
                                <span>: {{ $book->stok_buku }} Buku</span>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI (PINJAM & BACA) --}}
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">

                            {{-- 1. TOMBOL PINJAM BUKU FISIK --}}
                            @guest
                                {{-- JIKA TAMU (BELUM LOGIN) --}}
                                <a href="{{ route('login') }}"
                                    onclick="return confirm('Silakan login terlebih dahulu untuk meminjam buku.')"
                                    class="flex-1 text-center text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                    style="background-color: #595959;"> {{-- Warna Abu-abu --}}
                                    Pinjam Buku
                                </a>
                            @else
                                {{-- JIKA MEMBER (SUDAH LOGIN) --}}
                                @if ($book->stok_buku > 0)
                                    <form action="{{ route('peminjaman.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="buku_id" value="{{ $book->buku_id }}">
                                        <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">

                                        <button type="submit"
                                            class="w-full bg-[#7B96D4] hover:bg-[#5f7bc0] text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                            onclick="return confirm('Konfirmasi peminjaman buku: {{ $book->judul }}?')">
                                            Pinjam Buku
                                        </button>
                                    </form>
                                @else
                                    <div class="flex-1">
                                        <button disabled
                                            class="w-full bg-gray-300 text-gray-500 font-semibold py-3 px-8 rounded-lg cursor-not-allowed border border-gray-200">
                                            Stok Habis
                                        </button>
                                    </div>
                                @endif
                            @endguest


                            {{-- 2. TOMBOL BACA BUKU DIGITAL --}}
                            {{-- Cek apakah buku ini punya relasi ke buku_digital --}}
                            @if ($book->bukuDigital)
                                @guest
                                    {{-- JIKA TAMU (BELUM LOGIN) --}}
                                    <a href="{{ route('login') }}"
                                        onclick="return confirm('Silakan login terlebih dahulu untuk membaca buku digital.')"
                                        class="flex-1 text-center text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
                                        style="background-color: #595959;"> {{-- Warna Abu-abu --}}
                                        Baca Buku
                                    </a>
                                @else
                                    {{-- JIKA MEMBER (SUDAH LOGIN) --}}
                                    {{-- Asumsi: Route untuk baca adalah 'digital.show' --}}
                                    <a href="{{ route('digital.show', $book->bukuDigital->buku_digital_id) }}"
                                        target="_blank"
                                        class="flex-1 text-center bg-[#81A2DF] hover:bg-[#5f7bc0] text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                        {{-- Ikon Buku --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Baca Sekarang
                                    </a>
                                @endguest
                            @endif

                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <hr class="my-12 border-gray-200 dark:border-gray-700">

                {{-- SECTION 2: GRID BAWAH (Komentar & Sidebar) --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                    {{-- KOLOM KIRI (2/3): Area Komentar --}}
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-bold uppercase text-gray-500 mb-6">Tulis Komentar</h3>

                        {{-- Form Komentar --}}
                        <div class="flex gap-4 mb-10">
                            {{-- Avatar User Login --}}
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-xl">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>

                            <div class="flex-grow">
                                <form action="{{ route('reviews.store', $book->buku_id) }}" method="POST">
                                    @csrf
                                    {{-- Textarea --}}
                                    <textarea name="comment" rows="2"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                        placeholder="Ketik disini..."></textarea>

                                    {{-- Baris Bawah Input: Bintang & Tombol --}}
                                    <div class="flex justify-between items-center mt-3">
                                        {{-- Alpine JS Stars --}}
                                        <div x-data="{ rating: 0, hoverRating: 0 }" class="flex space-x-1">
                                            <input type="hidden" name="rating" :value="rating">
                                            <template x-for="star in 5">
                                                <button type="button" @click="rating = star"
                                                    @mouseover="hoverRating = star" @mouseleave="hoverRating = 0"
                                                    class="focus:outline-none">
                                                    <svg class="w-6 h-6 transition-colors duration-150"
                                                        :class="{
                                                            'text-gray-400': !(hoverRating >= star || (!hoverRating &&
                                                                rating >= star)),
                                                            'text-yellow-400': hoverRating >= star || (!hoverRating &&
                                                                rating >= star)
                                                        }"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>

                                        <button type="submit"
                                            class="bg-[#7B96D4] hover:bg-[#5f7bc0] text-white px-6 py-2 rounded-lg font-medium shadow-sm transition">
                                            Posting
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- List Komentar --}}
                        <h3 class="text-lg font-bold uppercase text-gray-500 mb-6">Komentar</h3>

                        <div class="space-y-8">
                            @forelse($book->reviews as $review)
                                <div class="flex gap-4">
                                    {{-- Avatar Komentar --}}
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-xl">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    {{-- Isi Komentar --}}
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span
                                                class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</span>

                                            {{-- Bintang User --}}
                                            <div class="flex text-yellow-400 text-sm">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        ★
                                                    @endif
                                                @endfor
                                            </div>

                                            <span class="text-gray-400 text-xs ml-auto sm:ml-2">•
                                                {{ $review->created_at->format('F d, Y') }}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada komentar. Jadilah yang pertama!</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- KOLOM KANAN (1/3): Buku Relevan --}}
                    <div>
                        <h3 class="text-lg font-bold uppercase text-gray-500 mb-6 text-center lg:text-left">Buku Yang
                            Relevan</h3>

                        <div class="flex flex-col gap-6">
                            @foreach ($relatedBooks as $related)
                                <div class="group">
                                    {{-- Card Buku Kecil --}}
                                    <div
                                        class="relative bg-gray-800 rounded-lg overflow-hidden shadow-lg aspect-[2/3] w-[180px] mx-auto lg:mx-0">
                                        <img src="{{ $related->cover ? asset('storage/' . $related->cover) : 'https://via.placeholder.com/150x225' }}"
                                            alt="{{ $related->judul }}"
                                            class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-300">

                                        {{-- Text Overlay --}}
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent flex flex-col justify-end p-4">
                                            <h4 class="text-white font-bold leading-tight mb-1">{{ $related->judul }}
                                            </h4>
                                        </div>
                                    </div>
                                    {{-- Tombol Periksa --}}
                                    <div class="mt-3 w-[180px] mx-auto lg:mx-0">
                                        <a href="{{ route('books.show', $related->buku_id) }}"
                                            class="block w-full bg-[#7B96D4] hover:bg-[#5f7bc0] text-white text-center py-2 rounded-md font-medium text-sm transition shadow-sm">
                                            Periksa
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div> {{-- End Grid Bawah --}}

            </div> {{-- End Kartu Utama --}}
        </div>
    </div>
</x-app-layout>
