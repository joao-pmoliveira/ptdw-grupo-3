@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', route('inicio.view')],
                ['recolha de restrições', route('restricoes.recolha.view')]
            ]
    ])

    @include('partials._pageTitle', ['title' => $page_title])

    <section id="alerts">
        @if (session('alerta'))
            <div class="alert alert-dismissible fade show bg-alert" role="alert">
                <p>
                    <i class="fa-solid fa-check"></i>
                    {{session('alerta')}}
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button> 
            </div>
        @endif
        @if (session('sucesso'))
            <div class="alert alert-dismissible fade show bg-accent" role="alert">
                <p>
                    <i class="fa-solid fa-check"></i>
                    {{session('sucesso')}}
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button> 
            </div>
        @endif
    </section>

    <section class="mt-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle='tab' data-bs-target='#manage-forms'>
                    Gerir Formulários
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#history'>
                    Histórico
                </button>
            </li>
        </ul>
    </section>

    <div class="tab-content">
        <section id="manage-forms" class="tab-pane active p-3">
            @php
                $docentesSemForm = $docentes->contains(fn ($item, $key) => $item->impedimentos()->where('periodo_id', $periodo->id)->doesntExist());
            @endphp

            <div class="d-flex justify-content-between mb-2">
                @if ($periodo->impedimentos->count() > 0)
                <div>
                    <h2>Formulário aberto: {{$periodo->ano . '/' . ($periodo->ano+1) . ' ' . $periodo->semestre . 'º Semestre'}}</h2>
                    <p>Data Limite: {{$periodo->data_final}}</p>
                </div>
                @else
                <div>
                    <p>Nenhum formulário ativo de momento.</p>
                </div>
                @endif
                <d-flex class="d-flex gap-2">
                    @if ($docentesSemForm)
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-new-process">
                        Gerar Formulários
                    </button>
                    @endif

                    @if ($periodo->impedimentos->count() > 0)
                    <button class="btn d-flex justify-content-center align-items-center">
                        <i class="fa fa-envelope-o"></i>
                    </button>

                    <a href="{{route('download')}}" class="btn d-flex justify-content-center align-items-center" download="output_restricoes.xlsx">
                        <i class="fa-solid fa-download"></i>
                    </a>
                    @endif
                </d-flex>
            </div>
            @if ($periodo->impedimentos->count() > 0)
            <table class="table-ua w-100" id="table">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1"></th>
                        <th scope="col-1">Nome</th>
                        <th scope="col-1" class="text-center">
                            Restrições de UCs 
                            ({{$periodo->unidadesCurriculares()->where('restricoes_submetidas',true)->count()}}/{{$periodo->unidadesCurriculares()->count()}})
                        </th>
                        <th scope="col-1" class="text-center">
                            Impedimento de Horário 
                            ({{$periodo->impedimentos()->where('submetido', true)->count()}}/{{$periodo->impedimentos->count()}})
                        </th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    @foreach ($periodo->impedimentos as $impedimento)
                    <tr class="border border-light pe-none">
                        <th scope="row"></th>
                        <td colspan="1">{{$impedimento->docente->numero_funcionario}}</td>
                        <td colspan="1">{{$impedimento->docente->user->nome}}</td>
                        <td colspan="1" class="text-center">
                            @if ($impedimento->docente->ucsResponsavel()->where('periodo_id', $periodo->id)->count() > 0)
                                {{$impedimento->docente->ucsResponsavel()->where('periodo_id', $periodo->id)->where('restricoes_submetidas', true)->count() .
                                    '/' .
                                    $impedimento->docente->ucsResponsavel()->where('periodo_id', $periodo->id)->count()
                                }}
                            @else
                                ---
                            @endif
                        </td>
                        <td colspan="1" class="text-center">
                            @if ($impedimento->submetido)
                                <i class="fa-solid fa-check"></i>
                            @else
                                Pendente
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </section>

        <section id="history" class="tab-pane p-3">
            <div class="d-flex gap-2 align-items-center">
                <h3>Histórico</h3>
            </div>

            <table class="table-ua w-100" id="history-table">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1"></th>
                        <th scope="col-4">Nome</th>
                        <th scope="col-1" style="text-align:center;">Restrições UC</th>
                        <th scope="col-1" style="text-align:center;">Impedimentos horários</th>
                        <th scope="col-1"></th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    @if ($periodosH->count() > 0)
                        @foreach ($periodosH as $index => $periodoH)
                            <tr data-bs-toggle="collapse" data-bs-target="{{'#rh'.$index}}">
                                <th scope="row"></th>
                                <td><i class="fa-solid fa-chevron-right"></i></td>
                                <td>Formulários {{$periodoH->ano . '/' . ($periodoH->ano+1)}} - {{$periodoH->semestre}}º semestre</td>
                                <td class="text-center">
                                    Submetidos:
                                    {{$periodoH->unidadesCurriculares()->where('restricoes_submetidas', true)->count()}}
                                    /
                                    {{$periodoH->unidadesCurriculares()->count()}}
                                </td>
                                <td class="text-center">
                                    Submetidos:
                                    {{$periodoH->impedimentos->where('submetido', true)->count()}}
                                    /
                                    {{$periodoH->impedimentos->count()}}
                                </td>
                                <td><i class="fa-solid fa-download"></i></td>
                            </tr>
                            @foreach ($docentes as $docente)
                                @if ($docente->impedimentos()->where('periodo_id', $periodoH->id)->exists())   
                                <tr class="collapse accordion-collapse bg-terciary pe-none" id="{{'rh'.$index}}">
                                    <th scope="row"></th>
                                    <td colspan="1">{{$docente->numero_funcionario}}</td>
                                    <td colspan="1">{{$docente->user->nome}}</td>
                                    <td colspan="1" class="text-center">
                                        @if ($docente->ucsResponsavel)
                                            {{$docente->ucsResponsavel()->where('periodo_id', $periodoH->id)->where('restricoes_submetidas', true)->count()}}
                                            /
                                            {{$docente->ucsResponsavel()->where('periodo_id', $periodoH->id)->count()}}
                                        @else ---
                                        @endif
                                    </td>
                                    <td colspan="1" class="text-center">
                                        @if ($docente->impedimentos()->where('periodo_id', $periodoH->id)->first()->submetido)
                                            <i class="fa fa-check"></i>
                                        @else
                                            Não submetido
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <tr class="border border-light pe-none">
                            <th scope="row"></th>
                            <td colspan="5">Sem correspondências</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </section>
    </div>

    <div class="modal fade" id="modal-new-process" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-0">
            <div class="modal-body">
                <form id="gerar-formularios-form" class="d-flex flex-column gap-3 px-5 py-4" action="{{route('impedimentos.periodo')}}" method="post">
                    @csrf
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <label class="w-50" for="ano-impedimentos-input">Ano Letivo:</label>
                        <input class="w-50" type="text" name="ano" id="ano-impedimentos-input">
                    </div>
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <label class="w-50" for="semestre-impedimentos-input">Semestre:</label>
                        <input class="w-50" type="number" name="semestre" id="semestre-impedimentos-input" min="1" max="2">
                    </div>
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <label class="w-50" for="data-inicial-impedimentos-input">Abre a :</label>
                        <input class="w-50" type="date" name="data_inicial" id="data-inicial-impedimentos-input">
                    </div>
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <label class="w-50" for="data-limite-impedimentos-input">Fecha a:</label>
                        <input class="w-50" type="date" name="data_limite" id="data-limite-impedimentos-input">
                    </div>
                    <div class="d-flex gap-3 justify-content-center" id="form-btns">
                        <input class="btn" type="submit" value="Submeter">
                        <input class="btn cancelar" data-bs-dismiss="modal" type="button" value="Cancelar">
                    </div>
                </form>
            </div>
        </div>

        </div>
    </div>

</main>
<script>
        var baseUrl = "{{ config('app.url') }}";
    </script>
<script src="{{asset('js/processos.js')}}" defer></script>

@endsection