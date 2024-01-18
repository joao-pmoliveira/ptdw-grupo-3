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

    <section class="mt-3 mb-4 p-0 d-flex flex-column gap-4">
        <div class="d-flex gap-4 align-items-stretch flex-wrap">
            <select class="" name="ano_semestre" id="ano_semestre" aria-label="Filtre por ano e semestre" 
            data-link="{{route('ucs.index')}}">
                @foreach ($periodos as $p)
                <option value="{{$p->ano . '_' . ($p->ano+1) . '_' . $p->semestre}}">
                    {{$p->ano . '/' . (substr($p->ano+1, 2,2)) . ' - ' . $p->semestre . 'º semestre'}}
                </option>
                @endforeach
            </select>

            <select name="curso" id="curso-uc-select">
                <option value="">Filtre por Curso</option>
                @foreach ($cursos as $curso)
                    <option value="{{$curso->id}}">{{$curso->sigla}}</option>
                @endforeach
            </select>

            <div class="paco-searchbox" id="filter-ucs-by-name-btn">
                <input type="text" name="uc" id="uc" aria-label="Filtre por código ou nome de uc" placeholder="Procurar por UCs">
                <div><i class="fa-solid fa-search"></i></div>
            </div>

            <div class="paco-checkbox">
                <label for="my-classes-check">As minhas UC's</label>
                <input type="checkbox" name="my_classes" id="my-classes-check">
            </div>
        </div>
    </section>

    <table class="w-100" id="table-ucs">
        <thead class="bg-light">
            <tr>
                <th scope="col"></th>
                <th scope="col">Cód</th>
                <th scope="col">Nome</th>
                <th scope="col">Docente Responsável</th>
            </tr>
        </thead>
        <tbody class="title-separator">
            @foreach ($ucs as $uc)
                <tr class="border border-light" data-id='{{$uc->id}}' 
                    data-my-uc='{{$user 
                                    ? $uc->docentes->contains($user->docente) ? 'Y' : 'N'
                                    : ''}}'
                    data-curso-id='{{implode(",",$uc->cursos->pluck("id")->toArray())}}'
                    data-link='{{route('ucs.uc.view', ['uc' => $uc->id])}}'>
                    <th scope="row"></th>
                    <td>{{$uc->codigo}}</td>
                    <td>{{$uc->nome}}</td>
                    <td>{{$uc->docenteResponsavel ? $uc->docenteResponsavel->user->nome : '-'}}</td>
                </tr>
            @endforeach

            <tr class="border border-light" id="ucs-no-match-row">
                <th scope="row"></th>
                <td colspan="3">Sem correspondências</td>
            </tr>
        </tbody>
    </table>

</main>

<script>const authUser = @json($user);</script>
<script src="{{asset('js/unidadesCurriculares.js')}}" defer></script>
@endsection