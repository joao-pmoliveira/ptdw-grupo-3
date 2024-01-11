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

    <section class="my-3 title-separator pt-2">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Área Científica</div>
            <div class="col-md-10"><p>{{ $uc->acn->nome }}</p></div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">ECTS</div>
            <div class="col-md-10"><p>{{ $uc->ects }}</p></div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Horas Semanais</div>
            <div class="col-md-10"><p>{{ $uc->horas_semanais}} horas</p></div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Docente Responsável</div>
            <div class="col-md-10">
                <p>{{$uc->docenteResponsavel->numero_funcionario .' - '. $uc->docenteResponsavel->user->nome}}</p>
            </div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Restantes Docentes</div>
            <div class="col-md-10">
                @foreach ( $uc->docentes as $docente)
                    @if ($docente->id != $uc->docenteResponsavel->id)
                        <p>{{$docente->numero_funcionario .' - '. $docente->user->nome}}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Restrições de Unidade Curricular </div>
            <div class="col-md-10">
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
    </section>



</main>
@endsection