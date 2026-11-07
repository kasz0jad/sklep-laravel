<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return view('admin.index');
});