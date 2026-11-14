<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Publiczne: sklep i koszyk (także dla gości)
Route::get('/', [ProductController::class, 'shop'])->name('shop');
Route::get('/koszyk', [CartController::class, 'index'])->name('cart.index');
Route::post('/koszyk/dodaj/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/koszyk/usun/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/kasa', [OrderController::class, 'checkout'])->name('checkout');

// Rejestracja i logowanie
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Przekierowanie do panelu właściwego dla roli
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect('/admin'),
        'moderator' => redirect('/moderator'),
        default => redirect('/klient'),
    };
})->middleware('auth');

// Profil (każdy zalogowany)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Klient
Route::middleware(['auth', 'role:klient'])->group(function () {
    Route::get('/klient', function () {
        return view('klient.index');
    });
    Route::post('/zamowienia', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/zamowienia', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/zamowienia/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Moderator i admin
Route::middleware(['auth', 'role:moderator,admin'])->group(function () {
    Route::get('/moderator', function () {
        return view('moderator.index');
    });

    Route::prefix('produkty')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');

    Route::resource('users', UserController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});