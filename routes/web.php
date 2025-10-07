<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
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
Route::middleware(['auth', 'permission:borrow_books'])->get('/borrow', fn() => view('books.borrow'))->name('books.borrow');
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

//denda
Route::middleware(['auth', 'permission:view_fines'])->get('/fines', fn() => view('fines.index'))->name('fines.index');
Route::middleware(['auth', 'permission:manage_fines'])->get('/admin/fines', fn() => view('admin.fines'))->name('admin.fines');

//reservasi
Route::middleware(['auth', 'permission:reserve_books'])->get('/reservations', fn() => view('reservations.index'))->name('reservations.index');
Route::middleware(['auth', 'permission:manage_reservations'])->get('/admin/reservations', fn() => view('admin.reservations'))->name('admin.reservations');

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

require __DIR__.'/auth.php';