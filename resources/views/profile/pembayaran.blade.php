<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Pembayaran') }}
        </h2>
    </x-slot>

    <div x-data="{ showModal: false, paymentMethod: '' }" class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <div class="payment-section">
                        <h3 class="payment-section-title">Detail Denda</h3>
                        <div class="payment-details">
                            <dl>
                                <dt>Nama</dt>
                                <dd>{{ $user->name }}</dd>

                                <dt>Keterangan</dt>
                                <dd>Denda Keterlambatan: {{ $peminjaman->buku->judul }}</dd>
                                
                                <dt class="mt-2">Total Denda</dt>
                                <dd class="mt-2 total">
                                    Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="payment-section">
                        <h3 class="payment-section-title">Pilih Metode Pembayaran</h3>
                        
                        <ul class="payment-method-list">
                            <li>
                                <label class="payment-method-label">
                                    <input x-model="paymentMethod" type="radio" name="payment-method" value="E-Wallet" class="payment-method-radio">
                                    <span class="payment-method-text">E-Wallet (GoPay, OVO, Dana)</span>
                                </label>
                            </li>
                            <li>
                                <label class="payment-method-label">
                                    <input x-model="paymentMethod" type="radio" name="payment-method" value="Virtual Account" class="payment-method-radio">
                                    <span class="payment-method-text">Virtual Account (BCA, Mandiri, BRI)</span>
                                </label>
                            </li>
                            <li>
                                <label class="payment-method-label">
                                    <input x-model="paymentMethod" type="radio" name="payment-method" value="Minimarket" class="payment-method-radio">
                                    <span class="payment-method-text">Minimarket (Alfamart, Indomaret)</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <button 
                            type="button" 
                            class="payment-button"
                            :disabled="!paymentMethod"  @click="showModal = true"   >
                            Bayar Sekarang
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div x-show="showModal" class="modal-container" style="display: none;">
            <div x-show="showModal" class="modal-overlay" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0"></div>

            <div x-show="showModal" @click.outside="showModal = false" class="modal-content"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="modal-header">
                    <h3 class="modal-title">
                        Konfirmasi Pembayaran
                    </h3>
                    <button type="button" class="modal-close-button" @click="showModal = false">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Anda akan melanjutkan pembayaran denda sebesar 
                        <strong class="text-gray-800 dark:text-white">Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</strong> 
                        menggunakan <strong class="text-gray-800 dark:text-white" x-text="paymentMethod"></strong>.
                    </p>
                    <p>
                        (Ini adalah prototipe. Klik 'Lanjutkan' untuk simulasi pembayaran berhasil.)
                    </p>
                </div>
                <div class="modal-footer">
                    <form action="#" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="payment_method" :value="paymentMethod">
                        <button type="submit" class="modal-button-primary w-full">
                            Ya, Lanjutkan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>