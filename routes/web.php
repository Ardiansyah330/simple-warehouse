<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
        Route::post('items', [ItemController::class, 'store'])->name('items.store');
        Route::put('items/{id}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    });