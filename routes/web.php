<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/registro', [UserController::class, 'create'])->name('user.formulario_registro');
Route::post('/registro', [UserController::class, 'store'])->name('user.store');
