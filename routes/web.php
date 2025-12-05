<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\BukuDigitalController;

// use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE UTAMA & AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('guest.home');
Route::get('/about-us', fn() => view('about'))->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN (User, Role, dan Lainnya)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'permission:manage_roles'])->group(function () {
    Route::resource('roles', RoleController::class)
        ->parameters(['roles' => 'user_role'])
        ->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);
});


//buku
Route::middleware(['auth', 'permission:view_books'])->get('/books', [BookController::class, 'index'])->name('books.index');
// Rute untuk menampilkan halaman Transaksi Peminjaman (yang kita buat)
Route::middleware(['auth', 'permission:borrow_books'])
    ->get('/borrow', [PeminjamanController::class, 'index'])
    ->name('books.borrow');

// 1. Rute untuk menampilkan form "Transaksi Baru"
Route::middleware(['auth', 'permission:borrow_books']) // Sesuaikan permission jika perlu
    ->get('/borrow/create', [PeminjamanController::class, 'create'])
    ->name('peminjaman.create');

// 2. Rute untuk memproses data form (menyimpan)
Route::middleware(['auth', 'permission:borrow_books']) // Sesuaikan permission jika perlu
    ->post('/borrow', [PeminjamanController::class, 'store'])
    ->name('peminjaman.store');

// Rute untuk tombol "Pengembalian"
Route::middleware(['auth', 'permission:return_books']) // Sesuaikan permission jika perlu
    ->post('/borrow/return/{peminjaman}', [PeminjamanController::class, 'kembali'])
    ->name('peminjaman.kembali');

// Rute untuk tombol "Cetak Nota"
Route::middleware(['auth', 'permission:borrow_books']) // Sesuaikan permission jika perlu
    ->get('/borrow/cetak/{peminjaman}', [PeminjamanController::class, 'cetak'])
    ->name('peminjaman.cetak');

//bayar sekarang
//Route::post('/peminjaman/{peminjaman}/bayar', [PaymentController::class, 'proses'])->name('pembayaran.proses');

Route::middleware(['auth', 'permission:return_books'])->get('/returns', fn() => view('books.return'))->name('books.return');
//Route::middleware(['auth', 'permission:manage_books'])->get('/books/manage', fn() => view('books.manage'))->name('books.manage');

// Buku CRUD (khusus admin & pustakawan)
Route::middleware(['auth', 'permission:manage_books'])->group(function () {
    Route::get('/books/manage', [BookController::class, 'manage'])->name('books.manage');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

Route::middleware(['auth', 'permission:manage_categories'])
    ->get('/categories', fn() => view('books.categories'))->name('books.categories');

/*
|--------------------------------------------------------------------------
| ANGGOTA
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'permission:view_members'])->group(function () {
    Route::get('/members', [PeminjamanController::class, 'daftarAnggota'])->name('members.index');
    Route::get('/members/{anggota}', [PeminjamanController::class, 'detailAnggota'])->name('members.detail');
});


Route::middleware(['auth', 'permission:manage_expired_members'])
    ->get('/admin/expired-members', fn() => view('admin.expired'))->name('admin.expired');

/*
|--------------------------------------------------------------------------
| PEMINJAMAN & DENDA (USER & ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ----------------------- USER -----------------------
    Route::middleware('permission:view_fines')->group(function () {

        // Halaman utama “Peminjaman Saya”
        Route::get('/peminjaman-saya', [PeminjamanController::class, 'index'])
            ->name('menu.peminjaman');

        // Cetak Nota
        Route::get('/peminjaman-saya/cetak/{peminjaman}', [PeminjamanController::class, 'cetak'])
            ->name('peminjaman.cetak');

        // Lihat Denda
        // DI routes/web.php

        // 1. Route untuk DAFTAR semua denda (tanpa parameter)
        Route::get('peminjaman-saya/fines', [PeminjamanController::class, 'index'])->name('fines.index');

        // 2. Route untuk DETAIL denda (dengan parameter)
        // Ubah nama route ini menjadi 'fines.show' agar lebih logis
        Route::get('peminjaman-saya/fines/{peminjaman}', [PeminjamanController::class, 'show'])->name('fines.show');

        // Pembayaran Denda (Order)
        Route::get('/peminjaman-saya/{denda}/confirm', [OrderController::class, 'confirm'])
            ->whereNumber('denda')->name('orders.confirm');
        Route::post('/peminjaman-saya/{denda}/process', [OrderController::class, 'process'])
            ->name('orders.process');

        // Status Pembayaran
        Route::get('/peminjaman-saya/{order}/waiting', [OrderController::class, 'waiting'])->name('fines.waiting');
        Route::get('/peminjaman-saya/{order}/check-status', [OrderController::class, 'checkStatus'])->name('fines.check-status');
        Route::get('/peminjaman-saya/{order}/success', [OrderController::class, 'success'])->name('fines.success');
    });

    // ----------------------- ADMIN -----------------------
    Route::middleware('permission:manage_fines')->group(function () {
        Route::get('/fines/admin', [DendaController::class, 'adminIndex'])->name('fines.admin');
        Route::post('/fines/{denda}/bayar', [DendaController::class, 'prosesPembayaran'])->name('fines.bayar');
        Route::post('/fines/{denda}/update-status', [DendaController::class, 'updateStatus'])->name('fines.update-status');
        Route::delete('/fines/{denda}', [DendaController::class, 'destroy'])->name('fines.destroy');
    });
});

// // Rute tambahan: proses pembayaran manual
// Route::post('/peminjaman/{peminjaman}/bayar', [PaymentController::class, 'proses'])
//     ->name('pembayaran.proses');

// Admin melihat semua peminjaman
Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])
    ->middleware(['permission:manage_books'])
    ->name('admin.peminjaman.index');

/*
|--------------------------------------------------------------------------
| RESERVASI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'permission:reserve_books'])
    ->get('/reservations', [ReservasiController::class, 'myReservations'])
    ->name('reservations.index');

Route::post('/reservasi/{buku}', [ReservasiController::class, 'store'])
    ->middleware(['auth', 'permission:reserve_books'])
    ->name('reservasi.store');

Route::middleware(['auth', 'permission:manage_reservations'])->group(function () {
    Route::get('/admin/reservations', [ReservasiController::class, 'index'])->name('admin.reservations');
    Route::post('/admin/reservations/siap/{reservasi}', [ReservasiController::class, 'tandaiSiapDiambil'])->name('admin.reservations.siap');
    Route::post('/admin/reservations/proses/{reservasi}', [ReservasiController::class, 'prosesPeminjaman'])->name('admin.reservations.proses');
    Route::post('/admin/reservations/batal/{reservasi}', [ReservasiController::class, 'batalkan'])->name('admin.reservations.batal');
});

/*
|--------------------------------------------------------------------------
| FITUR TAMBAHAN
|--------------------------------------------------------------------------
*/

// ==========================
// Buku Digital (CRUD & Akses)
// ==========================
Route::middleware(['auth'])->group(function () {

    // -------------------------- CREATE --------------------------
    Route::get('/digital-books/create', [BukuDigitalController::class, 'create'])
        ->middleware('permission:create_digital_books')
        ->name('digital.create');

    Route::post('/digital-books', [BukuDigitalController::class, 'store'])
        ->middleware('permission:create_digital_books')
        ->name('digital.store');

    // -------------------------- EDIT --------------------------
    Route::get('/digital-books/{id}/edit', [BukuDigitalController::class, 'edit'])
        ->middleware('permission:edit_digital_books')
        ->name('digital.edit');

    Route::put('/digital-books/{id}', [BukuDigitalController::class, 'update'])
        ->middleware('permission:edit_digital_books')
        ->name('digital.update');

    // -------------------------- DELETE --------------------------
    Route::delete('/digital-books/{id}', [BukuDigitalController::class, 'destroy'])
        ->middleware('permission:delete_digital_books')
        ->name('digital.destroy');

    // -------------------------- LIST --------------------------
    Route::get('/digital-books', [BukuDigitalController::class, 'index'])
        ->middleware('permission:access_digital_books')
        ->name('digital.index');

    // -------------------------- DETAIL --------------------------
    Route::get('/digital-books/{id}', [BukuDigitalController::class, 'show'])
        ->middleware('permission:access_digital_books')
        ->name('digital.show');

    // -------------------------- DOWNLOAD --------------------------
    Route::get('/digital-books/{id}/download', [BukuDigitalController::class, 'download'])
        ->middleware('permission:access_digital_books')
        ->name('digital.download');
});



Route::middleware(['auth', 'permission:view_reports'])
    ->get('/admin/reports', fn() => view('admin.reports'))->name('admin.reports');

Route::middleware(['auth', 'permission:register_member'])
    ->get('/register-member', fn() => view('guest.register'))->name('register.member');

/*
|--------------------------------------------------------------------------
| MENU
|--------------------------------------------------------------------------
*/

Route::get('/menu/buku', fn() => view('menu.buku'))->name('menu.buku');
Route::get('/menu/anggota', fn() => view('menu.anggota'))->name('menu.anggota');
Route::get('/menu/manajemen', fn() => view('menu.manajemen'))->name('menu.manajemen');
Route::get('/menu/laporan', fn() => view('menu.laporan'))->name('menu.laporan');

Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
});

/*
|--------------------------------------------------------------------------
| WEBHOOK
|--------------------------------------------------------------------------
*/

Route::post('/webhook/payment', [WebhookController::class, 'handlePayment'])->name('webhook.payment');

require __DIR__ . '/auth.php';
