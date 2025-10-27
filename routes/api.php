<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\BukuDigitalController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// User Management Routes
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// Member Management Routes
Route::prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{id}', [MemberController::class, 'show']);
    Route::put('/{id}', [MemberController::class, 'update']);
    Route::delete('/{id}', [MemberController::class, 'destroy']);
});

// Digital Book Management Routes
Route::prefix('digital-books')->group(function () {
    Route::get('/', [BukuDigitalController::class, 'index']);
    Route::post('/', [BukuDigitalController::class, 'store']);
    Route::get('/{id}', [BukuDigitalController::class, 'show']);
    Route::put('/{id}', [BukuDigitalController::class, 'update']);
    Route::delete('/{id}', [BukuDigitalController::class, 'destroy']);
});

// Report Routes
Route::prefix('reports')->group(function () {
    Route::get('/monthly/members', [ReportController::class, 'monthlyMemberReport']);
    Route::get('/monthly/digital-books', [ReportController::class, 'monthlyDigitalBookReport']);
    Route::get('/monthly/activities', [ReportController::class, 'monthlyActivityReport']);
    Route::get('/monthly/combined', [ReportController::class, 'combinedMonthlyReport']);
});