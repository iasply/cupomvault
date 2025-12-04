<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\SenhaController;
use App\Http\Middleware\CheckAssociado;
use App\Http\Middleware\CheckComercio;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'));

Route::prefix('cupomvault')->group(function () {
    Route::get('senha/esqueci', [SenhaController::class, 'form'])->name('senha.form');
    Route::post('senha/enviar', [SenhaController::class, 'send'])->name('senha.send');
    Route::get('senha/resetar/{token}', [SenhaController::class, 'resetForm'])->name('senha.reset.form');
    Route::post('senha/resetar', [SenhaController::class, 'reset'])->name('senha.reset');

    Route::get('/home', fn() => view('cupomvault.home'))->name('cupomvault.home');

    Route::prefix('comercio')->group(function () {
        Route::get('/registrar', [ComercioController::class, 'create'])->name('comercio.create');
        Route::post('/registrar', [ComercioController::class, 'store'])->name('comercio.save');
        Route::get('/login', [ComercioController::class, 'login'])->name('comercio.login');
        Route::post('/login', [ComercioController::class, 'autenticar'])->name('comercio.autenticar');
        Route::get('/logout', [ComercioController::class, 'logout'])->name('comercio.logout');

        Route::middleware([CheckComercio::class])->group(function () {
            Route::get('/home', [ComercioController::class, 'home'])->name('comercio.home');
            Route::get('/perfil', [ComercioController::class, 'perfil'])->name('comercio.perfil');

            Route::prefix('cupons')->group(function () {
                Route::get('/listar', [CupomController::class, 'listarCuponsComercio'])->name('comercio.cupons');
                Route::get('/usar', [CupomController::class, 'usar'])->name('comercio.usar');
                Route::get('/detalhes/{id}', [CupomController::class, 'detalhes'])->name('comercio.detalhes');
                Route::post('/usar', [CupomController::class, 'confirmarUso'])->name('comercio.usar');
                Route::post('', [CupomController::class, 'create'])->name('cupom.create');
                Route::post('/deletar', [CupomController::class, 'delete'])->name('cupom.delete');
                Route::get('/ativar/{id}', [CupomController::class, 'ativar'])->name('cupom.ativar');
            });
        });
    });

    Route::prefix('associado')->group(function () {
        Route::get('/registrar', [AssociadoController::class, 'create'])->name('associado.create');
        Route::post('/registrar', [AssociadoController::class, 'store'])->name('associado.save');
        Route::get('/login', [AssociadoController::class, 'login'])->name('associado.login');
        Route::post('/login', [AssociadoController::class, 'autenticar'])->name('associado.autenticar');
        Route::get('/logout', [AssociadoController::class, 'logout'])->name('associado.logout');

        Route::middleware([CheckAssociado::class])->group(function () {
            Route::get('/home', [AssociadoController::class, 'home'])->name('associado.home');

            Route::prefix('cupons')->group(function () {
                Route::get('', [CupomController::class, 'cuponsUsuario'])->name('associado.cupons');
                Route::get('/ativar/{id}', [CupomController::class, 'ativar'])->name('cupom.ativar');
            });

            Route::get('/perfil', [AssociadoController::class, 'perfil'])->name('associado.perfil');
        });
    });
});
