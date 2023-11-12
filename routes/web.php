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
    return view('welcome', ['page_title' => 'Bem vindo!']);
});

//Página Principal
Route::get('/home', function () {
    return view('home', ['page_title' => 'Página Inicial']);
});

//Página de Restrições (Docente)
Route::get('/restrictions', function () {
    return view('restrictions', ['page_title' => 'Restrições']);
});

//Página Formulário: Restrições (Docente)
Route::get('/restriction/{start_year}_{end_year}/{semester}/{id}', function ($start_year, $end_year, $semester, $id) {
    return view('restriction', [
        'page_title' => 'Restrições de Sala de Aula',
        'start_year' => $start_year,
        'end_year' => $end_year,
        'semester' => $semester,
        'id' => $id,
        'classes' => [
            ['id' => 2, 'name' => 'AP'],
            ['id' => 7, 'name' => 'MATI']
        ]
    ]);
});

//Página Formulário: Impedimentos (Docente)
Route::get('/schedule/{start_year}_{end_year}/{semester}/{id}', function ($start_year, $end_year, $semester, $id) {
    return view('schedule', [
        'page_title' => 'Impedimentos de Horário',
        'start_year' => $start_year,
        'end_year' => $end_year,
        'semester' => $semester,
        'id' => $id
    ]);
});

//Página de Gerir Processos (Admin)
Route::get('/processes', function () {
    return view('processes', ['page_title' => 'Gerir Processos']);
});

//Página de Consultar Unidades Curriculares (Utilizador)
Route::get('/ucs', function () {
    return view('unidadesCurriculares', ['page_title' => 'Consultar Unidades Curriculares']);
});

//Página de Unidade Curricular (Utilizador)
Route::get('/uc/{id}', function () {
    return view('unidade_curricular', ['page_title' => 'Unidade Curricular']);
});

//Página de Gerir Dados (Admin)
Route::get('/manage', function () {
    return view('gerirDados', ['page_title' => 'Gerir Dados']);
});