<x-app-layout>
    <div class="py-16 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mb-10">
                Tentang Sistem Manajemen Perpustakaan
            </h1>

            {{-- Deskripsi --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md">
                <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    Sistem Manajemen Perpustakaan ini dibuat untuk membantu perpustakaan dalam mengelola koleksi buku, 
                    anggota, serta transaksi peminjaman secara lebih mudah, cepat, dan efisien. 
                    Dengan antarmuka yang sederhana dan mudah dipahami, sistem ini dapat digunakan oleh pustakawan 
                    maupun anggota perpustakaan tanpa memerlukan pelatihan yang rumit.
                </p>

                <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                    Tujuan utama sistem ini adalah memastikan pengelolaan perpustakaan yang lebih terorganisir, 
                    mempersingkat waktu administrasi, serta memberikan pengalaman yang lebih praktis bagi pengguna.
                </p>

                {{-- Fitur --}}
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Fitur Utama
                </h2>

                <ul class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Katalog Buku</strong> — Menyediakan daftar lengkap koleksi buku dengan fitur pencarian untuk memudahkan pengguna menemukan buku yang mereka butuhkan.</p>
                    </li>

                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Manajemen Anggota</strong> — Mengelola data anggota perpustakaan termasuk status keanggotaan, informasi pribadi, dan histori peminjaman.</p>
                    </li>

                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Peminjaman & Pengembalian</strong> — Mencatat proses peminjaman dan pengembalian buku secara otomatis sehingga lebih akurat dan terstruktur.</p>
                    </li>

                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Perhitungan Denda Otomatis</strong> — Menghitung denda keterlambatan secara otomatis berdasarkan aturan yang berlaku, mengurangi risiko kesalahan manual.</p>
                    </li>

                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Sistem Reservasi</strong> — Pengguna dapat memesan buku yang sedang dipinjam oleh orang lain sehingga tidak perlu menunggu secara manual.</p>
                    </li>

                    <li class="flex items-start">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-3"></span>
                        <p><strong>Akses Buku Digital</strong> — Menyediakan koleksi buku digital yang dapat dibaca kapan saja dan di mana saja, meningkatkan fleksibilitas bagi pengguna.</p>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</x-app-layout>
