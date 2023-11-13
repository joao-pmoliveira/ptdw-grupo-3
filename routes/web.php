<?php

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

//Página de Entrada
Route::get('/', function () {
    return view('entrada', ['page_title' => 'Bem vindo!']);
});

//Página Principal
Route::get('/inicio', function () {
    return view('inicio', ['page_title' => 'Página Inicial']);
});

//Página de Restrições (Docente)
Route::get('/restrições', function () {
    return view('restrições', ['page_title' => 'Restrições']);
});

//Página Formulário: Restrições (Docente)
Route::get('/restrição/{ano_inicial}_{ano_final}/{semestre}/{id}', function ($ano_inicial, $ano_final, $semestre, $id) {
    return view('restrição', [
        'page_title' => 'Restrições de Sala de Aula',
        'ano_inicial' => $ano_inicial,
        'ano_final' => $ano_final,
        'semestre' => $semestre,
        'id' => $id,
        'classes' => [
            ['id' => 2, 'name' => 'AP'],
            ['id' => 7, 'name' => 'MATI']
        ]
    ]);
});

//Página Formulário: Impedimentos (Docente)
Route::get('/impedimento/{ano_inicial}_{ano_final}/{semestre}/{id}', function ($ano_inicial, $ano_final, $semestre, $id) {
    return view('impedimento', [
        'page_title' => 'Impedimentos de Horário',
        'ano_inicial' => $ano_inicial,
        'ano_final' => $ano_final,
        'semestre' => $semestre,
        'id' => $id
    ]);
});

//Página de Gerir Processos (Admin)
Route::get('/processos', function () {
    return view('processos', ['page_title' => 'Gerir Processos']);
});

//Página de Consultar Unidades Curriculares (Utilizador)
Route::get('/ucs', function () {
    return view('unidadesCurriculares', ['page_title' => 'Consultar Unidades Curriculares']);
});

//Página de Unidade Curricular (Utilizador)
Route::get('/uc/{id}', function ($id) {
    return view('unidadeCurricular', [
        'page_title' => 'Unidade Curricular',
        'id' => $id
    ]);
});
//Página de Editar Unidade Curricular (Admin)
Route::get('/uc/{id}/editar', function ($id) {
    return view('editarUnidadeCurricular', [
        'page_title' => 'Unidade Curricular', 
        'id' => $id
    ]);
});

//Página de Gerir Dados (Admin)
Route::get('/gerir', function () {
    return view('gerirDados', ['page_title' => 'Gerir Dados']);
});

Route::get('/docente/{id}', function ($id) {
    return view('docente', ['page_title' => 'Docente']);
});