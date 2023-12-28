@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
    'crumbs' => [
    ['página inicial', route('inicio.view')],
    ['unidades curriculares', route('ucs.view')],
    [strtolower($uc->nome), route('ucs.uc.view', ['uc' => $uc->id])]
    ]
    ])

    @include('partials._pageTitle', ['title' => $uc->codigo . ' - ' . $uc->nome])
    <!--  trocar Calculo I pelo nome da cadeira em, questao  - "$nomeUC"-->


    <section class="mt-3">
        <div class="mb-3 title-separator p-2">
        </div>

        <div class="mt-3">

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">Área Científica</div>
                <div class="col-8 col-md-10 p-3"><p>{{ $uc->acn->nome }}</p></div>
            </div>

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">ECTS's</div>
                <div class="col-8 col-md-10 p-3"><p>{{ $uc->ects }}</p></div>
            </div>

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">Horas Semanais</div>
                <div class="col-8 col-md-10 p-3"><p>{{ $uc->horas_semanais}} horas</p></div>
            </div>

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">Docente Responsável</div>
                <div class="col-8 col-md-10 p-3"><p>{{ $uc->docenteResponsavel->numero_funcionario }} - {{ $uc->docenteResponsavel->nome }}</p></div>
            </div>

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">Restantes Docentes</div>
                <div class="col-8 col-md-10 p-3">
                    @foreach ( $uc->docentes as $docente)
                        <p class="mb-2">{{ $docente->numero_funcionario }} - {{ $docente->nome }}</p>
                    @endforeach
                </div>
            </div>

            <div class="d-flex aling-items-center border border-dark p-2 mb-2 ">
                <div class="col-4 col-md-2 p-3">Restrições de Unidade Curricular </div>
                <div class="col-8 col-md-10 p-3">
                    <div class="mb-2">
                        Tipo de sala de aula:
                        @if ($uc->laboratorio === 1)
                            <p>Laboratório de Informática</p>
                        @elseif ($uc->laboratorio === 0)
                            <p>Sala Comum</p>
                        @endif
                    <div>

                    <div class="mb-2">
                        Software necessário:
                        @if ($uc->software)
                            <p>{{ $uc->software }}</p>
                        @else
                            <p>Não existe software necessário.</p>
                        @endif
                    <div>

                    <div class="mb-2">
                        Tipo de sala para avaliação:
                        @if ($uc->sala_avaliacao === 1)
                            <p>Laboratório de Informática</p>
                        @elseif ($uc->sala_avaliacao === 0)
                            <p>Sala Comum</p>
                        @endif
                    <div>
                </div>
            </div>
        </div>

    </section>



</main>
@endsection