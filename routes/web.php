<?php

use App\Http\Controllers\DiaFestivoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth as MiddlewareAuth;
use App\Models\DiaFestivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        return view('index');
    }
    return view('auth.login');
})->name('inicio');

Route::post('/login', function (Request $request) {

    $atributos = $request->validate([
        "email" => "required",
        "password" => "required"
    ]);

    if (Auth::attempt($atributos)) {
        return redirect(route('inicio'))->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Login successful.'
        ]);
    }
    return back()->with('alert', [
        'type' => 'danger',
        'title' => 'Error!',
        'message' => 'Incorrect credentials.'
    ]);
})->name('login');

Route::get('logout', function () {
    Auth::logout();
    return redirect(route('inicio'));})->name('logout');


Route::middleware(MiddlewareAuth::class)->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
    Route::delete('/deleteUsuario', [UserController::class, 'destroy'])->name('usuario.destroy');
    Route::put('/usuario', [UserController::class, 'update'])->name('usuario.update');
    Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
    Route::get('/diasfestivos', [DiaFestivoController::class, 'index'])->name('diasfestivos');
    Route::get('/diasfestivos/search', [DiaFestivoController::class, 'search'])->name('dias.search');
    Route::post('/diasfestivos', [DiaFestivoController::class, 'store'])->name('diasfestivos.store');
    Route::put('/diasfestivos', [DiaFestivoController::class, 'update'])->name('diasfestivos.update');
    Route::delete('/deleteDiaFestivo', [DiaFestivoController::class, 'destroy'])->name('diasfestivos.destroy');
    Route::get('/api/dias-festivos', function () {
        $diasFestivos = DiaFestivo::select('id', 'nombre', 'color', 'dia', 'mes', 'anio', 'recurrente')->get();
        return response()->json($diasFestivos);
    });
});
