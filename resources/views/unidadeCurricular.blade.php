@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio'],
                ['unidades curriculares', '/ucs']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Unidade Curricular '.$id])

   
    <section class="mt-5" >
        <div class="mb-3 title-separator p-2">
            <h1>91998 Cálculo I</h1>
        </div>

        <div class="mt-3">
            <div class="d-flex gap-5 aling-items-center border border-dark px-2">   
                <p>Departamento<p>
                <p>DMAT</p>
            </div>

            <div class="d-flex gap-5 aling-items-center border border-dark px-2">   
                <p>Área Científica<p>
                <p>Matemática</p>
            </div>

            <div class="d-flex gap-7 aling-items-center border border-dark px-2">   
                <p>ECT´s<p>
                <p>5</p>
            </div>

            <div class="d-flex gap-4 aling-items-center border border-dark px-2">   
                <p>Docente responsável<p>
                <p>12345 - Luísa Mendes</p>
            </div>

            <div class="d-flex gap-4 border border-dark px-2">   
                <p>Restantes Docentes<p>
                    <div class="d-flex flex-column gap-2">
                        <p>33555 - Rita Gonçalves</p>
                        <p>66221 - José Silva</p>
                    </div>
            </div>

            <div class="d-flex gap-4 border border-dark px-2">   
                <p>Restrições de sala<p>
                    <div class="d-flex flex-column">
                        <p>Escolha de sala - Obrigatória</p>
                        <p>5.1.10</p>
                        <p>5.1.10</p>
                        <p>5.1.29</p>
                        <p class="mt-4">Software necessário:</p>
                        <p>------------- ------------------ -----------</p>
                        <p>----------- --------- -------------- ------</p>
                        <p class="mt-4">Salas para avaliação:</p>
                        <p>5.1.10</p>
                    </div>
            </div>
        </div>

    </section>



    </main>
@endsection