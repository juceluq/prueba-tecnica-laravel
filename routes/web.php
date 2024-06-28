<?php

use App\Http\Controllers\DiaFestivoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('inicio');

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
Route::delete('/deleteUsuario', [UserController::class,'destroy'])->name('usuario.destroy');
Route::put('/usuario', [UserController::class,'update'])->name('usuario.update');
Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
Route::get('/diasfestivos', [DiaFestivoController::class, 'index'])->name('diasfestivos');
Route::get('/diasfestivos/search', [DiaFestivoController::class, 'search'])->name('dias.search');
Route::post('/diasfestivos', [DiaFestivoController::class, 'store'])->name('diasfestivos.store');
Route::put('/diasfestivos', [DiaFestivoController::class,'update'])->name('diasfestivos.update');
Route::delete('/deleteDiaFestivo', [DiaFestivoController::class,'destroy'])->name('diasfestivos.destroy');