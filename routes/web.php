<?php

use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\DocenteViewController;
use App\Http\Controllers\ImpedimentosViewController;
use App\Http\Controllers\RestricoesViewController;
use App\Http\Controllers\UnidadeCurricularViewController;
use App\Http\Controllers\WelcomeViewController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WelcomeViewController::class, 'welcome'])->name('welcome.view');

Route::get('/inicio', [WelcomeViewController::class, 'inicio'])->name('inicio.view');

Route::group(['prefix' => 'restricoes'], function () {

    Route::get('/', [RestricoesViewController::class, 'restricoes'])->name('restricoes.view');

    Route::get('/{uc}/{ano_inicial}-{ano_final}/{semestre}', [RestricoesViewController::class, 'restricoesUC'])->name('restricoes.uc.view');
    
    Route::get('/recolha', [RestricoesViewController::class, 'recolha'])->name('restricoes.recolha.view');

});

Route::group(['prefix' => 'impedimentos'], function () {
    
    Route::get('/{ano_inicial}-{ano_final}/{semestre}', [ImpedimentosViewController::class, 'impedimentos'])->name('impedimentos.view');

});

Route::group(['prefix' => 'ucs'], function () {

    Route::get('/', [UnidadeCurricularViewController::class, 'unidadesCurriculares'])->name('ucs.view');

    Route::get('/{uc}', [UnidadeCurricularViewController::class, 'unidadeCurricular'])->name('ucs.uc.view');

    Route::get('/{uc}/editar', [UnidadeCurricularViewController::class, 'editarUnidadeCurricular'])->name('ucs.editar.view');

});

Route::group(['prefix' => 'docentes'], function () {
    
    // todo - página para visualizar informações do docente
    // Route::get('/{docente}', []);

    Route::get('/{docente}/editar', [DocenteViewController::class, 'editarDocente'])->name('docentes.editar.view');

});

Route::get('/gerir-dados', [AdminViewController::class, 'gerirDados'])->name('admin.gerir.view');