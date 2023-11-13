@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Gerir Processos'])

    <section class="mt-5 mb-4 p-0">
        <h3 class="mb-2">Formulário em Processo:</h3>
        <div>
            <p class="mb-1">Nenhum formulário ativo de momento.</p>
            <button class="btn"
                    data-bs-toggle="modal" data-bs-target="#modal-new-process"
                    >Gerar formulário</button>
        </div>
    </section>


    <section class="mt-5 p-0 d-flex flex-column gap-4">
        
        <hr>
        <div class="d-flex gap-2 align-items-center" data-bs-toggle="collapse" data-bs-target="#history-table">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Histórico</h3>
        </div>
        <table class="accordion table-ua collapse accordion-collapse" id="history-table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1"></th>
                    <th scope="col-5">Nome</th>
                    <th scope="col-1">Data Limite</th>
                    <th scope="col-1">Submetidos</th>
                    <th scope="col-1"></th>
                    <th scope="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <!--Linha Principal--> 
                <tr data-bs-toggle="collapse" data-bs-target="#r1">
                    <th scope='row'></th>
                    <td ><i class="fa-solid fa-chevron-right"></i></td>
                    <td>Formulário 2023/24 2ºSemestre</td>
                    <td>31/12/2023</td>
                    <td>30/42</td>
                    <td><i class="fa-solid fa-download"></i></td>
                    <td><i class="fa-solid fa fa-envelope-o"></i></td>
                </tr>
                <!--Linha Colapsável-->
                <tr class="collapse accordion-collapse bg-terciary" id="r1" >
                    <th scope='row'></th>
                    <td colspan='1'>108746</td>
                    <td colspan='2'>Rui Fernandes</td>
                    <td colspan='1'>1/2</td>
                    <td colspan='2'>Pendente</td>
                </tr>
                <!--Linha Colapsável-->
                <tr class="collapse accordion-collapse bg-terciary" id="r1">
                    <th scope='row'></th>
                    <td colspan='1'>110111</td>
                    <td colspan='2'>José Silva</td>
                    <td colspan='1'>2/2</td>
                    <td colspan='2'>Submetido</td>
                </tr>

                <!--Linha Principal-->
                <tr data-bs-toggle="collapse" data-bs-target="#r2">
                    <th scope="row"></th>
                    <td><i class="fa-solid fa-chevron-right"></i></td>
                    <td>Formulário 2023/24 1ºSemestre</td>
                    <td>01/08/2023</td>
                    <td>42/42</td>
                    <td><i class="fa-solid fa-download"></i></td>
                    <td><i class="fa-solid fa fa-envelope-o"></i></td>
                </tr>
                <!--Linha Colapsável-->
                <tr class="collapse accordion-collapse bg-terciary" id="r2">
                    <th scope='row'></th>
                    <td colspan='1'>108746</td>
                    <td colspan='2'>Rui Fernandes</td>
                    <td colspan='1'>1/2</td>
                    <td colspan='2'>Pendente</td>
                </tr>
                <!--Linha Colapsável-->
                <tr class="collapse accordion-collapse bg-terciary" id="r2">
                    <th scope='row'></th>
                    <td colspan='1'>110111</td>
                    <td colspan='2'>José Silva</td>
                    <td colspan='1'>2/2</td>
                    <td colspan='2'>Submetido</td>
                </tr>
            </tbody>
        </table>
    </section>

    <div class="modal fade" id="modal-new-process" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-0">
            <div class="modal-body d-flex flex-column gap-3 px-5 py-4">
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="school-year">Ano Letivo:</label>
                    <input class="w-50" type="text" name="school_year" id="school-year">
                </div>
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="semester">Semester:</label>
                    <input class="w-50" type="number" name="semester" id="semester">
                </div>
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="due-date">Data Limite:</label>
                    <input class="w-50" type="date" name="due_date" id="due-date">
                </div>
                <div class="d-flex gap-3 justify-content-center" id="form-btns">
                    <input class="btn" type="button" value="Submeter">
                    <input class="btn" data-bs-dismiss="modal" type="button" value="Cancelar">
                </div>
            </div>
        </div>

        </div>
    </div>

</main>
@endsection