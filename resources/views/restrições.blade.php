@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio'],
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Preencher restrições'])

    <section class="mt-5 p-0 d-flex flex-column gap-4">
        <h3>Formulário Pendente</h3>
        <table class="w-100 title-separator" id="table-forms-pendentes">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1">Ano</th>
                    <th scope="col-1">Semestre</th>
                    <th scope="col-1">Nome</th>
                    <th scope="col-1">Estado</th>
                    <th scope="col-1">Data Limite</th>
                </tr>
            </thead>
            <tbody>
                <tr data-type='impedimento' data-start-year='2023' data-end-year='2024' data-semester='2'>
                    <th scope="row"></th>
                    <td>2023/24</td>
                    <td>2</td>
                    <td>Impedimentos de Horário</td>
                    <td>Pendente</td>
                    <td>31/12/2023</td>
                </tr>
                 <tr data-type='restrição' data-start-year='2023' data-end-year='2024' data-semester='1'>
                    <th scope="row"></th>
                    <td>2023/24</td>
                    <td>2</td>
                    <td>Restrições de Horário</td>
                    <td>Pendente</td>
                    <td>31/12/2023</td>
                </tr>
           </tbody>
        </table>

        <div class="d-flex gap-2 align-items-center">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Histórico</h3>
        </div>

        <table class="w-100 title-separator" id="table-historico-formularios">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1">Ano</th>
                    <th scope="col-1">Semestre</th>
                    <th scope="col-1">Nome</th>
                    <th scope="col-1">Estado</th>
                    <th scope="col-1">Data Limite</th>
                </tr>
            </thead>
            <tbody>
                <tr data-type="impedimento" data-start-year="2023" data-end-year="2024" data-semester="1">
                    <th scope="row"></th>
                    <td>2023/24</td>
                    <td>1</td>
                    <td>Impedimentos de Horário</td>
                    <td>Submetido</td>
                    <td>01/07/2023</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

@endsection