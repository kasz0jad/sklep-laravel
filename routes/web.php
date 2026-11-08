<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect('/admin'),
        'moderator' => redirect('/moderator'),
        default => redirect('/klient'),
    };
})->middleware('auth');

Route::middleware(['auth', 'role:klient'])->get('/klient', function () {
    return view('klient.index');
});

Route::middleware(['auth', 'role:moderator,admin'])->get('/moderator', function () {
    return view('moderator.index');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');

    Route::resource('users', UserController::class);
});

Route::middleware('auth')->get('/sklep', [ProductController::class, 'shop'])->name('shop');

Route::middleware(['auth', 'role:moderator,admin'])->prefix('produkty')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:klient'])->group(function () {
    Route::get('/koszyk', [CartController::class, 'index'])->name('cart.index');
    Route::post('/koszyk/dodaj/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/koszyk/usun/{product}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/zamowienia', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/zamowienia', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/zamowienia/{order}', [OrderController::class, 'show'])->name('orders.show');
});
