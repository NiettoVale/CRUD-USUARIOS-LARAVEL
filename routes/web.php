<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Front:
Route::get('/registro', [UserController::class, 'create'])->name('user.formulario_registro');
Route::get('/login', [UserController::class, 'formularioLogin'])->name('login');

// Rutas Privadas:
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Back:
Route::post('/registro', [UserController::class, 'store'])->name('user.store');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
