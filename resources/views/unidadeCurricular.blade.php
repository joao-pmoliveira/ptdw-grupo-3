@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio'],
                ['unidades curriculares', '/ucs'],
                ['unidade curricular - '.$id, '/ucs/'.$id]
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Cálculo I - '.$id])  <!--  trocar Calculo I pelo nome da cadeira em, questao  - "$nomeUC"-->

   
    <section class="mt-3" >
        <div class="mb-3 title-separator p-2">
        </div>

        <div class="mt-3">
            <div class="d-flex gap-5 aling-items-center border border-dark px-2 mb-2 p-2">   
                <p>Área Científica<p>
                <p>Matemática</p>
            </div>

            <div class="d-flex gap-6 aling-items-center border border-dark px-2 mb-2 p-2">   
                <p>ECTS´s<p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp5</p>
            </div>
            <div class="d-flex gap-4 aling-items-center border border-dark px-2 mb-2 p-2">   
                <p>Horas Semanais<p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp4 horas</p>
            </div>

            <div class="d-flex gap-4 aling-items-center border border-dark px-2 mb-2 p-2">   
                <p>Docente responsável<p>
                <p>&nbsp12345 - Luísa Mendes</p>
            </div>

            <div class="d-flex gap-4 border border-dark px-2 mb-2 p-2">   
                <p>Restantes Docentes<p>
                    <div class="d-flex flex-column gap-2">
                        <p>&nbsp&nbsp&nbsp33555 - Rita Gonçalves</p>
                        <p>&nbsp&nbsp&nbsp66221 - José Silva</p>
                    </div>
            </div>

            <div class="d-flex gap-4 border border-dark px-2 p-2">   
                <p>Restrições de Unidade <br> Curricular<p>
                    <div class="d-flex flex-column">
                        <p>Tipo de sala de aula: </p>
                        <p>Laboratório</p>  <!-- ou não -->
                        <p class="mt-4">Software necessário:</p>
                        <p>------------- ------------------ -----------</p>
                        <p>----------- --------- -------------- ------</p>
                        <p class="mt-4">Tipo de sala para avaliação:</p>
                        <p>Laboratório</p> <!-- ou Sala Comum -->
                    </div>
            </div>
        </div>

    </section>



    </main>
@endsection