<?php

use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\Api\UnidadeCurricularController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DocenteViewController;
use App\Http\Controllers\ImpedimentosViewController;
use App\Http\Controllers\RegistoController;
use App\Http\Controllers\RestricoesViewController;
use App\Http\Controllers\UnidadeCurricularViewController;
use App\Http\Controllers\WelcomeViewController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;
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

    Route::get('/{uc}/{ano_inicial}/{semestre}', [RestricoesViewController::class, 'restricoesUC'])->name('restricoes.uc.view');

    Route::get('/recolha', [RestricoesViewController::class, 'recolha'])->name('restricoes.recolha.view');
});

Route::group(['prefix' => 'impedimentos'], function () {

    Route::get('/{docente}/{ano_inicial}/{semestre}/', [ImpedimentosViewController::class, 'impedimentos'])->name('impedimentos.view');
});

Route::group(['prefix' => 'ucs'], function () {

    Route::get('/adicionar', [UnidadeCurricularViewController::class, 'addUnidadeCurricular'])->name('ucs.adicionar.view');

    Route::get('/{uc}', [UnidadeCurricularViewController::class, 'unidadeCurricular'])->name('ucs.uc.view');

    Route::get('/{uc}/editar', [UnidadeCurricularViewController::class, 'editarUnidadeCurricular'])->name('ucs.editar.view');

    Route::get('/', [UnidadeCurricularViewController::class, 'unidadesCurriculares'])->name('ucs.view');
});

Route::group(['prefix' => 'docentes'], function () {

    // todo - página para visualizar informações do docente
    // Route::get('/{docente}', []);

    Route::get('/{docente}/editar', [DocenteViewController::class, 'editarDocente'])->name('docentes.editar.view');
    Route::get('/adicionar', [DocenteViewController::class, 'addDocente'])->name('docente.adicionar.view');
});

Route::get('/gerir-dados', [AdminViewController::class, 'gerirDados'])->name('admin.gerir.view');

// Rotas de Autenticação
Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'show'])->name('login.view');

    Route::post('/', [LoginController::class, 'authenticate'])->name('login.action');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout.action');

Route::group(['prefix' => 'registo'], function () {
    Route::get('/', [RegistoController::class, 'show'])->name('registo.view');

    Route::post('/', [RegistoController::class, 'register'])->name('registo.action');
});

Route::group(['prefix' => 'perfil'], function () {
    Route::get('/', [PerfilController::class, 'perfil'])->name('perfil.view');

    Route::post("/", [PerfilController::class, 'editarPerfil'])->name('perfil.edit.view');
});

