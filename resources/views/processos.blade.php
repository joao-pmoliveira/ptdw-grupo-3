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

    <section class="mt-3 d-flex flex-column">
        @php
            $docenteSemFormulario = $docentes->contains(fn ($item, $key) => $item->impedimentos()->where('periodo_id', $periodo->id)->get()->isEmpty());
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
            <div class="d-flex gap-2">
                @if ($docenteSemFormulario)
                <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-new-process">
                    Gerar Formulários
                </button>
                @endif
                @if ($periodo->impedimentos->count() > 0)
                <button class="btn">
                    <i class="fa fa-envelope-o"></i>
                </button>
                <button class="btn">
                    <i class="fa-solid fa-download"></i>
                </button>
                @endif
            </div>
        </div>

        @if ($periodo->impedimentos->count() > 0)
        <table class="accordion table-ua collapse accordion-collapse show" id="table">
            <thead class="bg-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1"></th>
                    <th scope="col-1">Nome</th>
                    <th scope="col-1" class="text-center">Restrições de UCs</th>
                    <th scope="col-1" class="text-center">Impedimento de Horário</th>
                </tr>
            </thead>
            <tbody class="title-separator">
                @foreach ($periodo->impedimentos as $impedimento)
                <tr class="border border-light">
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

    <hr class="my-5">

    <section class="d-flex flex-column gap-4">
        <div class="d-flex gap-2 align-items-center" data-bs-toggle="collapse" data-bs-target="#history-table">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Histórico</h3>
        </div>

        @if (true)
            <p>Histórico indisponível</p>
        @else
        <table class="accordion table-ua collapse accordion-collapse title-separator" id="history-table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1"></th>
                    <th scope="col-4">Nome</th>
                    <th scope="col-1">Data Limite</th>
                    <th scope="col-1" style="text-align:center;">Restrições UC</th>
                    <th scope="col-1" style="text-align:center;">Impedimentos horários</th>
                    <th scope="col-1"></th>
                    <th scope="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <!--Linha Principal--> 
                @foreach($periodosH as $index => $periodoH)
                <tr data-bs-toggle="collapse" data-bs-target="{{'#rh' . $index}}">
                    <th scope='row'></th>
                    <td ><i class="fa-solid fa-chevron-right"></i></td>
                    <td>{{'Formulário ' . $periodoH->ano . '/' . ($periodoH->ano + 1) . ' ' . $periodoH->semestre . 'ºSemestre'}}</td>
                    <td>{{$periodoH->data_final}}</td>
                    <td style="text-align:center;">4/4</td>
                    <td style="text-align:center;">2/2</td>
                    <td><i class="fa-solid fa-download"></i></td>
                </tr>
                    @foreach($docentes as $docente)
                    <tr class="collapse accordion-collapse bg-terciary" id="{{'rh' . $index}}">
                        <th scope='row'></th>
                        <td colspan='1'>{{$docente->numero_funcionario}}</td>
                        <td colspan='2'>{{$docente->user->nome}}</td>
                        <td colspan='1' style="text-align:center;">{{
                            $docente->ucResponsavel 
                                ? $docente->ucResponsavel->restricoes_submetidas . '/' . (bool)$docente->ucResponsavel 
                                : 'Não é docente responsável'
                        }}</td>
                        <td colspan='2' style="text-align:center;">{{
                            $docente->impedimentos()->where('periodo_id' , $periodo->id)->first() == NULL ? 'Pendente':
                                ($docente->impedimentos()->where('periodo_id' , $periodo->id)->first()->submetido ?'Submetido' : 'Pendente')
                        }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @endif
        
    </section>

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
                        <input class="btn" data-bs-dismiss="modal" type="button" value="Cancelar">
                    </div>
                </form>
            </div>
        </div>

        </div>
    </div>

</main>

<script src="{{asset('js/processos.js')}}" defer></script>

@endsection