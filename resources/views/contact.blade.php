<x-app-layout>
    <div class="py-16 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mb-10">
                Hubungi Kami
            </h1>

            {{-- Konten --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md">

                {{-- Deskripsi --}}
                <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                    Jika Anda memiliki pertanyaan, saran, atau kendala terkait Sistem Manajemen Perpustakaan,
                    silakan hubungi kami melalui form berikut atau melalui informasi kontak yang tersedia.
                    Tim kami akan dengan senang hati membantu Anda.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Form Kontak --}}
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Kirim Pesan
                        </h2>

                        <form action="#" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium">Nama Lengkap</label>
                                <input type="text"
                                    class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-blue-300"
                                    required>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium">Email</label>
                                <input type="email"
                                    class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-blue-300"
                                    required>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium">Pesan</label>
                                <textarea rows="4"
                                    class="w-full border dark:border-gray-700 rounded-lg px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-blue-300"
                                    required></textarea>
                            </div>

                            <button
                                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                                Kirim
                            </button>
                        </form>
                    </div>

                    {{-- Informasi Kontak --}}
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Informasi Kontak
                        </h2>

                        <div class="space-y-4 text-gray-700 dark:text-gray-300">

                            <p>
                                Untuk bantuan atau kebutuhan administrasi, Anda dapat menghubungi kami melalui:
                            </p>

                            <ul class="space-y-3">
                                <li>
                                    📍 <strong>Alamat:</strong><br>
                                    Jl. Perpustakaan No. 12, Jakarta
                                </li>
                                <li>
                                    📧 <strong>Email:</strong><br>
                                    support@librarysystem.com
                                </li>
                                <li>
                                    📞 <strong>Telepon:</strong><br>
                                    +62 812-3456-7890
                                </li>
                            </ul>

                            <hr class="my-5 border-gray-300 dark:border-gray-700">

                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                Jam Operasional
                            </h3>
                            <p>
                                Senin – Jumat : 08:00 – 17:00 <br>
                                Sabtu : 08:00 – 12:00 <br>
                                Minggu : Libur
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
