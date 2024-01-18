@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['gerir dados', route('admin.gerir.view')]
        ]
    ])

    @include('partials._pageTitle', ['title' => $uc->codigo . ' - ' . $uc->nome])

    <section class="mt-3 title-separator pt-2">
        <div id="alerts">
            @if (session('alerta'))
                <div class="alert alert-dismissible fade show bg-alert mb-2" role="alert">
                    <p><i class="fa-solid fa-check"></i>{{session('alerta')}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button> 
                </div>
            @endif
            @if (session('sucesso'))
                <div class="alert alert-dismissible fade show bg-accent mb-2" role="alert">
                    <p><i class="fa-solid fa-check"></i>{{session('sucesso')}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button> 
                </div>
            @endif
        </div>

        <form id="edit-uc-form" action="{{route('ucs.update', ['id' => $uc->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="d-flex align-items-center p-2">
                <label for="uc-codigo-input" class="col-md-2">Código</label>
                <input class="col-md-2 px-1" type="text" name="codigo" id="uc-codigo-input" value="{{$uc->codigo}}"
                    placeholder="Código" required>
            </div>

            <hr class="m-0 bg-secondary">
            
            <div class="d-flex align-items-center p-2">
                <label for="uc-nome-input" class="col-md-2">Nome</label>
                <input class="col-md-4 px-1" type="text" name="nome" id="uc-nome-input" value="{{$uc->nome}}"
                    placeholder="Nome" required>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-acn-select" class="col-md-2">Área Científica</label>
                <select class="col-md-1 p-1" name="acn" id="uc-acn-select" required>
                    @foreach ($acns as $acn)
                        <option value="{{$acn->id}}" @selected($uc->acn->id == $acn->id)>{{$acn->nome}}</option>
                    @endforeach
                </select>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-ects-input" class="col-md-2">ECTS</label>
                <input class="col-md-2 px-1" type="number" name="ects" id="uc-ects-input" 
                    value="{{$uc->ects}}" required>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-horas" class="col-md-2">Horas Semanais</label>
                <input class="col-md-2 px-1" type="number" name="horas" id="uc-horas-input"
                    value="{{$uc->horas_semanais}}" required>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-main-teacher" class="col-md-2">Docente Responsável</label>
                <select class="col-md-2 p-1" name="docente_responsavel_id" id="uc-main-teacher-select">
                    <option value="">---</option>
                    @foreach ($docentes as $docente)
                        @php
                            $responsavel = $uc->docenteResponsavel && $uc->docenteResponsavel->id === $docente->id;
                            $jaAssociado = !$responsavel && $uc->docentes->contains($docente);
                        @endphp
                        <option value="{{$docente->id}}" 
                            @selected($responsavel)
                            @disabled($jaAssociado)
                        >    
                            {{$docente->numero_funcionario}} - {{$docente->user->nome}}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-teachers" class="col-md-2">Restantes Docentes</label>
                <div class="d-flex flex-column gap-2 col-md-6">
                    @foreach ($uc->docentes as $ucDocente)
                        @if (!$uc->docenteResponsavel || $ucDocente->id !== $uc->docenteResponsavel->id)
                            <select class="col-md-2 p-1" name="docentes_id[]">
                                <option value="">---</option>
                                @foreach ($docentes as $docente)
                                    @php
                                        $selecionado = $ucDocente->id === $docente->id
                                    @endphp
                                    <option value="{{$docente->id}}"
                                        @selected($selecionado)
                                    >
                                        {{$docente->numero_funcionario}} - {{$docente->user->nome}}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    @endforeach

                    @php
                        $count = $uc->docenteResponsavel ? 4-count($uc->docentes) : 3-count($uc->docentes);
                    @endphp

                    @for ($i = 0; $i < $count; $i++)
                        <select class="col-md-2 p-1" name="docentes_id[]">
                            <option value="">---</option>
                            @foreach ($docentes as $docente)
                                <option value="{{$docente->id}}" @disabled($uc->docentes->contains($docente))>
                                    {{$docente->numero_funcionario}} - {{$docente->user->nome}}
                                </option>
                            @endforeach
                        </select>
                    @endfor
                </div>
            </div>
            <div class="d-flex gap-3 mt-3 mb-5">
                <input class="btn" type="submit" value="Submeter">
                <input type="button" class="btn remover" id="btn-delete" value="Remover">
                <a class="btn cancelar" href="{{route('admin.gerir.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>

        <form id="delete-uc-form" action="{{route('ucs.delete', ['id' => $uc->id])}}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </section>
</main>

<script src="{{asset('js/editUC.js')}}" defer></script>

@endsection