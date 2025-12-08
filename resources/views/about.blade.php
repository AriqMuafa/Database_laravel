<x-app-layout>
    <div class="py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Sistem Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500">Perpustakaan</span>
                </h1>
                <p class="mt-4 text-lg text-slate-600">
                    Solusi digital untuk pengelolaan administrasi perpustakaan yang modern, cepat, dan efisien.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16 items-stretch">

                <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-blue-200 shadow-sm">
                    <h2 class="text-2xl font-bold text-slate-800 mb-4">Tentang Aplikasi</h2>
                    <div class="prose text-slate-700 leading-relaxed space-y-4">
                        <p>
                            Sistem Manajemen Perpustakaan ini dibuat untuk membantu perpustakaan dalam mengelola koleksi buku,
                            anggota, serta transaksi peminjaman secara lebih mudah.
                        </p>
                        <p>
                            Dengan antarmuka yang sederhana dan mudah dipahami, sistem ini dapat digunakan oleh pustakawan
                            maupun anggota perpustakaan tanpa memerlukan pelatihan yang rumit.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-blue-700 text-white p-8 rounded-2xl shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>

                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Tujuan Utama
                    </h3>
                    <p class="text-blue-50 leading-relaxed">
                        "Memastikan pengelolaan perpustakaan yang lebih terorganisir, mempersingkat waktu administrasi, serta memberikan pengalaman yang lebih praktis bagi pengguna."
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex items-center space-x-2 mb-8">
                    <div class="h-8 w-1 bg-blue-700 rounded-full"></div>
                    <h2 class="text-2xl font-bold text-slate-800">Fitur Unggulan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Katalog Buku</h3>
                        <p class="text-sm text-slate-600">Pencarian buku cepat dan daftar koleksi lengkap untuk pengguna.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Manajemen Anggota</h3>
                        <p class="text-sm text-slate-600">Kelola status, info pribadi, dan histori peminjaman anggota.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Peminjaman</h3>
                        <p class="text-sm text-slate-600">Pencatatan otomatis peminjaman dan pengembalian yang akurat.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Denda Otomatis</h3>
                        <p class="text-sm text-slate-600">Kalkulasi denda keterlambatan otomatis tanpa hitung manual.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">Reservasi</h3>
                        <p class="text-sm text-slate-600">Pesan buku yang sedang dipinjam tanpa perlu menunggu di lokasi.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-blue-200 hover:border-blue-400 transition-colors duration-300 shadow-sm hover:shadow-md">
                        <div class="mb-4 text-blue-700 bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2">E-Book Access</h3>
                        <p class="text-sm text-slate-600">Akses koleksi buku digital fleksibel kapan saja dan di mana saja.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
