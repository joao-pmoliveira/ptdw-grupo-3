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

    <div class="d-flex align-items-center justify-content-between">
        @include('partials._pageTitle', ['title' => $uc->codigo . ' - ' . $uc->nome])
        <div class="d-flex gap-2">
            @if ($user->admin)
            <a href="{{route('ucs.editar.view', ['uc' => $uc->id])}}" class="btn">Editar</a>
            @endif
            @if ($uc->docenteResponsavel && $user->docente && $uc->docenteResponsavel->id == $user->docente->id)
            <a href="{{route('restricoes.uc.view', ['uc' => $uc->id, 'ano_inicial' => $uc->periodo->ano, 'semestre' => $uc->periodo->semestre])}}" class="btn">Restrições</a>
            @endif
        </div>
    </div>

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
                @if ($uc->docenteResponsavel)
                    <p>{{$uc->docenteResponsavel->numero_funcionario}} - {{$uc->docenteResponsavel->user->nome}}</p>
                @else
                    <p>N/A</p>
                @endif
            </div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2">Restantes Docentes</div>
            <div class="col-md-10">
                @foreach ( $uc->docentes as $docente)
                    @if (!$uc->docenteResponsavel || $uc->docenteResponsavel->id === $docente->id)
                    <p>{{$docente->numero_funcionario}} - {{$docente->user->nome}}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <hr class="m-0 bg-secondary">
        <div class="d-flex align-items-center p-2">
            <div class="col-md-2 align-self-start">Restrições de Unidade Curricular </div>
            <div class="col-md-10">
                <div class="mb-2">
                    <h3 class="font-weight-normal">Sala para aulas</h3>
                    <p>{{$uc->sala_laboratorio ? 'Laboratório de Informática' : 'Sala Comum'}}</p>
                </div>
                <div class="mb-2">
                    <h3 class="font-weight-normal">Sala para Exames (Época Normal)</h3>
                    <p>{{$uc->exame_final_laboratorio ? 'Laboratório de Informática' : 'Sala Comum'}}</p>
                </div>
                <div class="mb-2">
                    <h3 class="font-weight-normal">Sala para Exames (Época Recurso)</h3>
                    <p>{{$uc->exame_recurso_laboratorio ? 'Laboratório de Informática' : 'Sala Comum'}}</p>
                </div>
                <div class="mb-2">
                    <h3 class="font-weight-normal">Observações sobre requisão de salas:</h3>
                    <p>{{$uc->observacoes_laboratorios ? $uc->observacoes_laboratorios : 'Não especificado.'}}</p>
                </div>
                <div class="mb-2">
                    <h3 class="font-weight-normal">Software necessário</h3>
                    <p>{{$uc->software ? $uc->software : 'Não especificado.'}}</p>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection