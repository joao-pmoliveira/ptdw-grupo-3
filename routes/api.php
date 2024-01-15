<?php

use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\DocenteController;
use App\Http\Controllers\Api\ImpedimentoController;
use App\Http\Controllers\Api\UnidadeCurricularController;
use App\Http\Controllers\Api\UploadController;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'docentes'], function () {

    Route::get('/', [DocenteController::class, 'index'])->name('docentes.index');

    Route::get('/{docente}', [DocenteController::class, 'show'])->name('docentes.show');

    Route::post('/', [DocenteController::class, 'store'])->middleware(['web', 'auth'])->name('docentes.store');

    Route::put('/{id}', [DocenteController::class, 'update'])->middleware(['web', 'auth'])->name('docentes.update');

    Route::delete('/{id}', [DocenteController::class, 'delete'])->middleware(['web', 'auth'])->name('docentes.delete');
});

Route::group(['prefix' => 'unidades-curriculares'], function () {
    Route::get('/', [UnidadeCurricularController::class, 'index'])->name('ucs.index');

    Route::get('/{uc}', [UnidadeCurricularController::class, 'show'])->name('ucs.show');

    Route::get('/por-ano-semestre/{ano}/{semestre}', [UnidadeCurricularController::class, 'getByAnoSemestre'])->name('ucs.ano-semestre');

    Route::post('/', [UnidadeCurricularController::class, 'store'])->middleware(['web', 'auth'])->name('ucs.store');

    Route::put('/{id}', [UnidadeCurricularController::class, 'update'])->middleware(['web', 'auth'])->name('ucs.update');

    Route::delete('/{id}', [UnidadeCurricularController::class, 'delete'])->middleware(['web', 'auth'])->name('ucs.delete');
});

Route::group(['prefix' => 'restricoes'], function () {
    Route::put('/{id}', [UnidadeCurricularController::class, 'updateRestricao'])->middleware(['web', 'auth'])->name('restricoes.update');
});

Route::group(['prefix' => 'impedimentos'], function () {
    Route::get('/', [ImpedimentoController::class, 'index'])->name('impedimentos.index');

    Route::get('/{impedimento}', [ImpedimentoController::class, 'show'])->name('impedimentos.show');

    Route::post('/', [ImpedimentoController::class, 'store'])->name('impedimentos.store');

    Route::put('/{id}', [ImpedimentoController::class, 'update'])->middleware(['web', 'auth'])->name('impedimentos.update');

    Route::delete('/{id}', [ImpedimentoController::class, 'delete'])->middleware(['web', 'auth'])->name('impedimentos.delete');

    Route::post('/periodo', [ImpedimentoController::class, 'gerarPorPeriodo'])->middleware(['web', 'auth'])->name('impedimentos.periodo');
});

Route::post('/upload-excel', [UploadController::class, 'upload'])->name('upload');

Route::get('/download-excel', [UploadController::class, 'download'])->name('download');
