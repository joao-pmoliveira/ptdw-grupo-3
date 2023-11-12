@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página Inicial', '/home'],
                ['gerir processos', '/processes']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Gerir Processos'])

    <section class="container-fluid mt-5 p-0 d-flex flex-column gap-4">
        <h3>Formulário em Processo:</h3>   
        <p>
            Nenhum formulário se encontra ativo neste momento.
        </p>
        
        <div class="d-flex">
            <input class="d-block m-0 py-2 px-3 btn btn-primary rounded-0 border border-primary btn-outline-0 shadow-none text-primary button-txt text-capitalize" type="button" value="Gerar formulário" >
        </div>

        <table class="w-100">
            <tbody>
                <tr> <!-- Quando estivesse aberto ter algo assim? style="background-color: rgba(14, 180, 189, 0.5); color:#292929"  -->
                    <th class="col-1" scope="row"><i class="fa-solid fa-chevron-down"></i></th>
                    <th class="col-1" scope="row" >Nº Mec. </th>
                    <th class="col-4">Formulário 2023/24 1º Semestre</th>
                    <th class="col-3">Data Limite: 01/07/2023</th>
                    <th class="col-2">Submetidos: 30/42</th>
                    <th class="col-1"><i class="fa-solid fa fa-download"></i></th>
                    <th class="col-1"><i class="fa-solid fa fa-envelope-o"></i></th>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">108746</td>
                    <td>Rui Fernandes</td>
                    <td></td>
                    <td>1/2</td>
                    <td>Pendente</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">110111</td>
                    <td>José Silva</td>
                    <td></td>
                    <td>2/2</td>
                    <td>Submetido</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">110568</td>
                    <td>Ana Domingues</td>
                    <td></td>
                    <td>1/1</td>
                    <td>Submetido</td>
                    <td></td>
                </tr>
           </tbody>
        </table>

    </section>


    <section class="container-fluid mt-5 p-0 d-flex flex-column gap-4">
        <div class="d-flex gap-2 align-items-center">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Histórico</h3>
        </div>
        <table class="w-100">
            <tbody>
                <tr>
                    <th class="col-1" scope="row" ><i class="fa-solid fa-chevron-right"></i></th>
                    <th class="col-5">Formulário 2023/24 1º Semestre</th>
                    <th class="col-2">01/07/2023</th>
                    <th class="col-2">42/42</th>
                    <th class="col-1"><i class="fa-solid fa fa-download"></i></th>
                    <th class="col-1"><i class="fa-solid fa fa-envelope-o"></i></th>
                </tr>
                <tr>
                    <th class="col-1" scope="row" ><i class="fa-solid fa-chevron-right"></i></th>
                    <th class="col-5">Formulário 2022/23 2º Semestre</th>
                    <th class="col-2">31/12/2022</th>
                    <th class="col-2">40/40</th>
                    <th class="col-1"><i class="fa-solid fa fa-download"></i></th>
                    <th class="col-1"><i class="fa-solid fa fa-envelope-o"></i></th>
                </tr>
           </tbody>
        </table>
    </section>
</main>
@endsection