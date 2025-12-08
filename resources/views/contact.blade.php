<x-app-layout>
    {{-- Background putih dan aksen biru dominan --}}
    <div class="py-16 bg-white min-h-screen flex items-center justify-center">
        <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul dengan aksen biru --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-slate-900">
                    Hubungi <span class="text-blue-700">Kami</span>
                </h1>
                <p class="mt-4 text-lg text-slate-700 max-w-2xl mx-auto">
                    Kami siap membantu kebutuhan perpustakaan Anda. Jangan ragu untuk mengirimkan pesan.
                </p>
                <div class="w-24 h-1 bg-blue-700 mx-auto mt-6 rounded-full"></div>
            </div>

            {{-- Konten Utama --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-blue-200">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    {{-- Kiri: Informasi Kontak (Aksen biru) --}}
                    <div class="bg-blue-50 p-10 flex flex-col justify-between relative overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-200 rounded-full opacity-40 blur-2xl"></div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-900 mb-6">
                                Informasi Kontak
                            </h2>
                            <p class="text-blue-700 mb-8 leading-relaxed">
                                Untuk bantuan teknis, saran fitur, atau kebutuhan administrasi, tim kami siap melayani Anda melalui kanal berikut:
                            </p>

                            <ul class="space-y-6">
                                <li class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-blue-900">Alamat</h3>
                                        <p class="text-blue-700 text-sm">Jl. Perpustakaan No. 12, Jakarta</p>
                                    </div>
                                </li>

                                <li class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-blue-900">Email</h3>
                                        <p class="text-blue-700 text-sm">support@librarysystem.com</p>
                                    </div>
                                </li>

                                <li class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-blue-900">Telepon</h3>
                                        <p class="text-blue-700 text-sm">+62 812-3456-7890</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="mt-10 border-t border-blue-300 pt-6">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2">Jam Operasional</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm text-blue-700">
                                    <div>
                                        <span class="block font-medium text-blue-900">Senin – Jumat</span>
                                        08:00 – 17:00
                                    </div>
                                    <div>
                                        <span class="block font-medium text-blue-900">Sabtu</span>
                                        08:00 – 12:00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Kontak --}}
                    <div class="p-10 bg-white">
                        <h2 class="text-2xl font-bold text-blue-900 mb-6">
                            Kirim Pesan
                        </h2>

                        <form action="#" method="POST" class="space-y-6">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full rounded-lg border-blue-300 bg-blue-50 text-blue-900 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-3 px-4" placeholder="Masukkan nama Anda" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Alamat Email</label>
                                <input type="email" class="w-full rounded-lg border-blue-300 bg-blue-50 text-blue-900 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-3 px-4" placeholder="nama@email.com" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Pesan</label>
                                <textarea rows="4" class="w-full rounded-lg border-blue-300 bg-blue-50 text-blue-900 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-3 px-4" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
