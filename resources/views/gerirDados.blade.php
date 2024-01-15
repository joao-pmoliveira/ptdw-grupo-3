@extends('layouts.baseContent')

@section('main')
<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['gerir dados', route('admin.gerir.view')]
        ]
    ])
    
    @include('partials._pageTitle', ['title' => 'Gerir Dados'])

    <section class="mt-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle='tab' data-bs-target='#manage-ucs'>
                    Gerir Unidades Curriculares
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#manage-teachers'>
                    Gerir Docentes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#import-data'>
                    Importar Serviço-Docente
                </button>
            </li>
        </ul>
    </section>

    <div class="tab-content pt-3">
        <section id="manage-ucs" class="tab-pane active">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-wrap">
                    <div class="d-flex gap-4 align-items-stretch my-2 flex-grow-1 flex-wrap">
                        <select class="px-2" name="school_year_semester" id="school-year-semester" aria-label="Filtre por ano e semestre">
                            @foreach ($periodos as $periodo)
                                <option value="{{$periodo->ano . "_" . ($periodo->ano+1) . "_" . $periodo->semestre}}">
                                    {{$periodo->ano . "/" . substr($periodo->ano+1, 2,2) . " " . $periodo->semestre . "º Semestre"}}
                                </option>
                            @endforeach
                        </select>
                        <select class="px-2" name="school_course" id="school-year-school_course" aria-label="Filtre por curso">
                            <option value="" selected>Filtre Por Curso</option>
                            @foreach ($cursos as $curso)
                            <option value="{{$curso->id}}">{{$curso->sigla}}</option>
                            @endforeach
                        </select>
                        <div class="paco-searchbox">
                            <input type="text" name="nome_cod_uc" id="input-filter-ucs-nome" aria-label="Filtre por código ou nome de uc" placeholder="Procurar por UC">
                            <div><i class="fa-solid fa-search"></i></div>
                        </div>
                        <div class="paco-checkbox ">
                            <label class="d-block" for="ucs-sem-responsavel-check">Sem Docente Responsável</label>
                            <input type="checkbox" name="" id="ucs-sem-responsavel-check">
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{route('ucs.adicionar.view')}}" class="btn py-1">Adicionar UC</a>
                    </div>
                </div>
                
                <table  id="table-edit-ucs">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col-1">Cód.</th>
                            <th scope="col-5">Nome</th>
                            <th scope="col-3">Docente Responsável</th>
                            <th scope="col-1"></th>
                        </tr>
                    </thead>
                    <tbody class="title-separator">
                        @foreach($ucs as $index => $uc)
                            <tr class="border border-light" data-id='{{$uc->id}}' data-curso-id='{{implode(",",$uc->cursos->pluck("id")->toArray())}}'>
                                <th scope="row"></th>
                                <td>{{$uc->codigo}}</td>
                                <td>{{$uc->nome}}</td>
                                @if($uc->docenteResponsavel)
                                <td>{{$uc->docenteResponsavel->user->nome}}</td>
                                @else
                                <td>---</td>
                                @endif
                                <td><i class="fa-solid fa-pen"></i></td>
                            </tr>
                        @endforeach
                        <tr class="border border-light" id="edit-ucs-no-match-row">
                            <th scope="row"></th>
                            <td colspan="3">Sem correspondências</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="manage-teachers" class="tab-pane">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-wrap justify-content-between my-2">
                    <div class="paco-searchbox">
                        <input type="text" name="teacher_identifier" id="teacher-identifier" placeholder="Procurar por Docente" aria-label="Filtre por número mecanográfico ou nome do docente">
                        <div><i class="fa-solid fa-search"></i></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{route('docente.adicionar.view')}}" class="btn py-1">Adicionar Docente</a>
                    </div>
                </div>
                <table id="table-edit-teachers">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nº</th>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="title-separator">
                        @foreach($docentes as $docente)
                            <tr class="border border-light" data-id='{{$docente->id}}'>
                                <th scope="row"></th>
                                <td>{{$docente->numero_funcionario}}</td>
                                <td>{{$docente->user->nome}}</td>
                                <td><i class="fa-solid fa-pen"></i></td>
                            </tr>
                        @endforeach
                        
                        <tr class="border border-light" id="edit-teachers-no-match-row">
                            <th scope="row"></th>
                            <td colspan="3">Sem correspondências</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="import-data" class="tab-pane">
            <form action="{{route('upload')}}" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                @csrf
                <div>
                    <label class="col-md-2" for="file-start-year">Começo de Ano Letivo</label>
                    <input class="col-md-1" type="number" name="file-start-year" id="file-start-year-input" placeholder="2023" required>
                </div>
                <div>
                    <label class="col-md-2" for="file-semestre">Semestre</label>
                    <input class="col-md-1" type="number" name="file-semestre" id="file-semestre-input" placeholder="2" required>
                </div>
                <div>
                    <label class="col-md-2" for="import-file-input">Selecione um ficheiro</label>
                    <input class="col-md-4" type="file" accept=".xlsx" name="uc-data-file" id="import-file-input" required>
                </div>
                <div class="d-flex gap-3">
                    <input class="btn" type="submit" value="Submeter">
                </div>
            </form>
        </section>
    </div>
    
</main>
@auth
    <script>
        const authUser = @json(auth()->user());
        var baseUrl = "{{ config('app.url') }}";
    </script>
@endauth
<script src="{{asset('js/gerirDados.js')}}" defer></script>
@endsection