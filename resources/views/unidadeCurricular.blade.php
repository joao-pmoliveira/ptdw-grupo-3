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

    <section class="mt-3">
        <div class="mb-3 title-separator p-2">
        </div>

        <div class="mt-3">
            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">Área Científica</div>
                <div class="col-md-10 p-3"><p>{{ $uc->acn->nome }}</p></div>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">ECTS</div>
                <div class="col-md-10 p-3"><p>{{ $uc->ects }}</p></div>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">Horas Semanais</div>
                <div class="col-md-10 p-3"><p>{{ $uc->horas_semanais}} horas</p></div>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">Docente Responsável</div>
                <div class="col-md-10 p-3">
                    <p>{{$uc->docenteResponsavel->numero_funcionario .' - '. $uc->docenteResponsavel->user->nome}}</p>
                </div>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">Restantes Docentes</div>
                <div class="col-md-10 p-3">
                    @foreach ( $uc->docentes as $docente)
                        <p>{{$docente->numero_funcionario .' - '. $docente->user->nome}}</p>
                    @endforeach
                </div>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2 ">
                <div class="col-md-2 p-3">Restrições de Unidade Curricular </div>
                <div class="col-md-10 p-3">
                    <div class="mb-2">
                        <h3 class="font-weight-normal">Tipo de Sala de aula:</h3>
                        <p>{{$uc->laboratorio ? 'Laboratório de Informática' : 'Sala Comum'}}</p>
                    </div>

                    <div class="mb-2">
                        <h3 class="font-weight-normal">Software necessário</h3>
                        <p>{{$uc->software ? $uc->software : 'Não especificado.'}}</p>
                    </div>

                    <div class="mb-2">
                        <h3 class="font-weight-normal">Tipo de Sala para Avaliação:</h3>
                        <p>{{$uc->sala_avaliacao ? 'Laboratório de Informática' : 'Sala Comum'}}</p>
                    </div>
                </div>
            </div>
        </div>

    </section>



</main>
@endsection