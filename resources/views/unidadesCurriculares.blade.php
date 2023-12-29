@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
    'crumbs' => [
    ['página inicial', route('inicio.view')],
    ['unidades curriculares', route('ucs.view')]
    ]
    ])

    @include('partials._pageTitle', ['title' => 'Consultar Unidades Curriculares'])

    <section class="mt-5 mb-4 p-0 d-flex flex-column gap-4">
        <div class="d-flex gap-4 align-items-stretch flex-wrap">

            <select class="" name="ano_semestre" id="ano_semestre" aria-label="Filtre por ano e semestre">
                @foreach ($periodos as $p)
                <option value="{{$p->ano . '_' . ($p->ano+1) . '_' . $p->semestre}}">
                    {{$p->ano . '/' . (substr($p->ano+1, 2,2)) . ' - ' . $p->semestre . 'º semestre'}}
                </option>
                @endforeach
            </select>


            <div class="paco-searchbox">
                <input type="text" name="uc" id="uc" aria-label="Filtre por código ou nome de uc">
                <div><i class="fa-solid fa-search"></i></div>
            </div>

            <div class="paco-checkbox">
                <label for="my-classes-check">As minhas UC's</label>
                <input type="checkbox" name="my_classes" id="my-classes-check">
            </div>

        </div>
    </section>


    <table class="w-100 title-separator" id="table-ucs">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Cód</th>
                <th scope="col">Nome</th>
                <th scope="col">Docente Responsável</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ucs as $uc)
                <tr data-id='{{$uc->id}}'>
                    <th scope="row"></th>
                    <td>{{$uc->codigo}}</td>
                    <td>{{$uc->nome}}</td>
                    <td>{{$uc->docenteResponsavel->nome}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</main>
@endsection