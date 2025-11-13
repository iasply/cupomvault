<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CupomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::prefix('cupomvault')->group(function () {

    Route::get('/home', fn() => view('cupomvault.home'))->name('cupomvault.home');
    Route::prefix('/comercio')->group(function () {
        Route::get('', [ComercioController::class, 'create'])->name('comercio.create');
        Route::post('', [ComercioController::class, 'store'])->name('comercio.save');
        Route::get('/login', [ComercioController::class, 'login'])->name('comercio.login');
        Route::post('/login', [ComercioController::class, 'autenticar'])->name('comercio.autenticar');
        Route::get('/home', [ComercioController::class, 'home'])->name('comercio.home');
        Route::get('/logout', [ComercioController::class, 'logout'])->name('comercio.logout');
        Route::get('/perfil', [ComercioController::class, 'perfil'])->name('comercio.perfil');
        Route::prefix('/cupom')->group(function () {
            Route::get('/listar', [CupomController::class, 'listarCuponsComercio'])->name('comercio.cupons');
        });
    });

    Route::prefix('/cupom')->group(function () {
        Route::post('', [CupomController::class, 'create'])->name('cupom.create');
        Route::post('/deletar', [CupomController::class, 'delete'])->name('cupom.delete');
        Route::get('/cupom/ativar/{id}', [CupomController::class, 'ativar'])->name('cupom.ativar');
    });


    Route::prefix('/associado')->group(function () {

        Route::get('', [AssociadoController::class, 'create'])->name('associado.create');
        Route::post('', [AssociadoController::class, 'store'])->name('associado.save');
        Route::get('/login', [AssociadoController::class, 'login'])->name('associado.login');
        Route::post('/login', [AssociadoController::class, 'autenticar'])->name('associado.autenticar');
        Route::get('/logout', [AssociadoController::class, 'logout'])->name('associado.logout');
        Route::get('/home', [AssociadoController::class, 'home'])->name('associado.home');
        Route::get('/cupom', [CupomController::class, 'cuponsUsuario'])->name('associado.cupons');

    });


});
