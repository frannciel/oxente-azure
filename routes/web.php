<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LicitacaoController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'homeProfile'])->middleware('auth')->name('profile.home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function(){
    Route::controller(LicitacaoController::class)->prefix('licitacao')->name('licitacao.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/novo', 'store')->name('store');
        Route::get('/exibir', 'show')->name('show'); 
    });
});

Route::middleware(['auth', 'requisitante'])->group(function(){
    Route::controller(RequisicaoController::class)->prefix('requisicao')->name('requisicao.')->group(function(){
		Route::get('/', 'index')->name('index');
		Route::get('/novo','create')->name('create');
		Route::post('/novo','store')->name('store');
        Route::get('/exibir/{id}', 'show')->name('show'); 
        Route::get('/importar','import')->name('import');
    });
});



require __DIR__.'/auth.php';
