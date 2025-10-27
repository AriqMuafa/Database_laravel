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
use Illuminate\Support\Facades\Route;

//halaman utama
Route::get('/', fn() => view('welcome'))->name('guest.home');

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//profile default
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('users', App\Http\Controllers\UserController::class);

Route::prefix('admin')->middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
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


Route::middleware(['auth', 'permission:manage_categories'])->get('/categories', fn() => view('books.categories'))->name('books.categories');

//anggota
Route::middleware(['auth', 'permission:view_members'])->get('/members', fn() => view('members.index'))->name('members.index');
Route::middleware(['auth', 'permission:manage_expired_members'])->get('/admin/expired-members', fn() => view('admin.expired'))->name('admin.expired');

// PEMINJAMAN & DENDA (USER & ADMIN)
Route::middleware(['auth'])->group(function () {

    //user
    Route::middleware('permission:view_fines')->group(function () {

        // Halaman utama "Peminjaman Saya"
        Route::get('/peminjaman-saya', [PeminjamanController::class, 'index'])->name('menu.peminjaman');
        Route::get('/peminjaman-saya/fines', [PeminjamanController::class, 'finesIndex'])
        ->name('fines.index');
        
        // Pembayaran Denda (Order)
        Route::get('/peminjaman-saya/{denda}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::post('/peminjaman-saya/{denda}/process', [OrderController::class, 'process'])->name('orders.process');

        // Status Pembayaran
        Route::get('/peminjaman-saya/{order}/waiting', [OrderController::class, 'waiting'])->name('orders.waiting');
        Route::get('/peminjaman-saya/{order}/check-status', [OrderController::class, 'checkStatus'])->name('orders.check-status');
        Route::get('/peminjaman-saya/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    });

    //admin
    Route::middleware('permission:manage_fines')->group(function () {
        Route::get('/fines/admin', [DendaController::class, 'adminIndex'])->name('fines.admin');
        Route::post('/fines/{denda}/update-status', [DendaController::class, 'updateStatus'])->name('fines.update-status');
        Route::delete('/fines/{denda}', [DendaController::class, 'destroy'])->name('fines.destroy');
    });
});


// Rute baru untuk Admin/Pustakawan melihat semua pinjaman
Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])
     ->middleware(['permission:manage_books']) // Sesuaikan permission jika perlu
     ->name('admin.peminjaman.index');

//reservasi

// Rute untuk USER melihat halaman "Reservasi Saya" (MENGGANTIKAN RUTE LAMA)
Route::middleware(['auth', 'permission:reserve_books'])
    ->get('/reservations', [ReservasiController::class, 'myReservations'])
    ->name('reservations.index');

// Rute untuk USER membuat reservasi (BARU)
Route::post('/reservasi/{buku}', [ReservasiController::class, 'store'])
    ->middleware(['auth', 'permission:reserve_books']) 
    ->name('reservasi.store');

// GANTI RUTE LAMA INI:
// Route::middleware(['auth', 'permission:manage_reservations'])->get('/admin/reservations', fn() => view('admin.reservations'))->name('admin.reservations');

// DENGAN 4 RUTE BARU INI:
Route::middleware(['auth', 'permission:manage_reservations'])->group(function () {
    // 1. Halaman utama Kelola Reservasi
    Route::get('/admin/reservations', [ReservasiController::class, 'index'])
        ->name('admin.reservations');

    // 2. Tombol "Tandai Siap Diambil"
    Route::post('/admin/reservations/siap/{reservasi}', [ReservasiController::class, 'tandaiSiapDiambil'])
        ->name('admin.reservations.siap');

    // 3. Tombol "Proses Peminjaman"
    Route::post('/admin/reservations/proses/{reservasi}', [ReservasiController::class, 'prosesPeminjaman'])
        ->name('admin.reservations.proses');

    // 4. Tombol "Batalkan"
    Route::post('/admin/reservations/batal/{reservasi}', [ReservasiController::class, 'batalkan'])
        ->name('admin.reservations.batal');
});
//buku digital
Route::middleware(['auth', 'permission:access_digital_books'])->get('/digital-books', fn() => view('digital.index'))->name('digital.index');

//laporan
Route::middleware(['auth', 'permission:view_reports'])->get('/admin/reports', fn() => view('admin.reports'))->name('admin.reports');

//guest
Route::middleware(['auth', 'permission:register_member'])->get('/register-member', fn() => view('guest.register'))->name('register.member');
// ROLE MANAGEMENT
Route::middleware(['auth', 'permission:manage_roles'])->group(function () {
    Route::resource('roles', RoleController::class)
        ->parameters(['roles' => 'user_role']) 
        ->names([
            'index'   => 'roles.index',
            'create'  => 'roles.create',
            'store'   => 'roles.store',
            'show'    => 'roles.show',
            'edit'    => 'roles.edit',
            'update'  => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);
});

Route::get('/menu/buku', function () {
    return view('menu.buku');
})->name('menu.buku');

Route::get('/menu/anggota', function () {
    return view('menu.anggota');
})->name('menu.anggota');

Route::get('/menu/manajemen', function () {
    return view('menu.manajemen');
})->name('menu.manajemen');

Route::get('/menu/laporan', function () {
    return view('menu.laporan');
})->name('menu.laporan');





Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
});

// Webhook Route (no auth middleware)
Route::post('/webhook/payment', [WebhookController::class, 'handlePayment'])->name('webhook.payment');

require __DIR__.'/auth.php';
