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

    <section class="mt-3">
        <form id="edit-uc-form" action="{{route('ucs.update', ['id' => $uc->id])}}" method="POST"
            class="title-separator">
            @csrf
            @method('PUT')
            <div class="mb-3">
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-codigo-input" class="col-md-2 p-3">Código</label>
                <input class="col-md-2 p-1" type="text" name="codigo" id="uc-codigo-input" value="{{$uc->codigo}}"
                    placeholder="Cód" required>
            </div>

            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-nome-input" class="col-md-2 p-3">Nome</label>
                <input class="col-md-6 p-1" type="text" name="nome" id="uc-nome-input" value="{{$uc->nome}}"
                    placeholder="Nome" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-acn-select" class="col-md-2 p-3">Área Científica</label>
                <select class="col-md-2 p-1" name="acn" id="uc-acn-select" required>
                    <option value="{{$uc->acn_id}}" selected>{{$uc->sigla}}</option>
                    @foreach ($acns as $acn)
                    <option value="{{$acn->sigla}}">{{$acn->sigla}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-ects-input" class="col-md-2 p-3">ECTS</label>
                <input class="col-md-2 p-1" type="number" name="ects" id="uc-ects-input" value="{{$uc->ects}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-horas" class="col-md-2 p-3">Horas Semanais</label>
                <input class="col-md-2 p-1" type="number" name="horas" id="uc-horas-input"
                    value="{{$uc->horas_semanais}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-main-teacher" class="col-md-2 p-3">Docente Responsável</label>
                <select class="col-md-2 p-1" name="docente_responsavel_id" id="uc-main-teacher-select" required>
                    <option value="{{$uc->docenteResponsavel->id}}" selected>
                        {{$uc->docenteResponsavel->numero_funcionario .' - '. $uc->docenteResponsavel->user->nome}}
                    </option>
                    @foreach ($docentes as $docente)
                    <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="uc-teachers" class="col-md-2 p-3">Restantes Docentes</label>
                <div class="d-flex flex-column gap-2 col-md-4 p-1">
                    @foreach ( $uc->docentes as $docente)
                        <select name="docentes_id[]">
                            <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}
                        </option>
                        @foreach($docentes as $docente)
                            <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}
                            </option>
                        @endforeach
                    </select>
                    @endforeach
                    @for ($i = 0; $i < 4-count($uc->docentes) ; $i++) 
                        <select name="docentes_id[]">
                        <option value="">Selecione</option>
                            @foreach($docentes as $docente)
                                <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}
                                </option>
                            @endforeach
                        </select>
                    @endfor
                </div>
            </div>
            <div class="d-flex gap-3 mt-3 mb-5" id="form-btns">
                <input class="btn" type="submit" value="Submeter">
                <input class="btn" id="btnDelete" type="button" value="Remover">
                <a class="btn" href="{{route('admin.gerir.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>

    </section>

</main>
<script>
    const deleteUCRoute = "{{route('ucs.delete', ['id' => $uc->id])}}";
</script>
@auth
<script>
    const authUser = @json(auth() -> user());
</script>
@endauth
<script src="{{asset('js/editUC.js')}}" defer></script>

@endsection