<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('inicio');

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
