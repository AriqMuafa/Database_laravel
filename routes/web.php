<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

//Halaman utama
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//halaman profile default
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('/admin/users', fn() => "Halaman kelola user (Admin only)")
        ->name('admin.users');
});
Route::middleware(['auth', 'permission:view_reports'])->group(function () {
    Route::get('/admin/reports', fn() => "Laporan perpustakaan (Admin only)")
        ->name('admin.reports');
});

//pustakawan
Route::middleware(['auth', 'permission:manage_books'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});
Route::middleware(['auth', 'permission:return_books'])->group(function () {
    Route::get('/returns', fn() => "Halaman pengembalian buku (Pustakawan only)")
        ->name('books.return');
});

//anggota
Route::middleware(['auth', 'permission:borrow_books'])->group(function () {
    Route::get('/borrow', fn() => "Halaman pinjam buku (Anggota only)")
        ->name('books.borrow');
});

//guest
Route::get('/', function () {
    return view('welcome'); // default welcome page
})->name('guest.home');


require __DIR__.'/auth.php';