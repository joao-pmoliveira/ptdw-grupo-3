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
        <form id="edit-uc-form" action="{{route('ucs.update', ['id' => $uc->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="d-flex align-items-center p-2">
                <label for="uc-codigo-input" class="col-md-2">Código</label>
                <input class="col-md-2 px-1" type="text" name="codigo" id="uc-codigo-input" value="{{$uc->codigo}}"
                    placeholder="Cód" required>
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
                    <option value="{{$uc->acn->id}}" selected>{{$uc->acn->sigla}}</option>
                    @foreach ($acns as $acn)
                        @if ($acn->id != $uc->acn->id)
                        <option value="{{$acn->id}}">{{$acn->sigla}}</option>
                        @endif
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
                <select class="col-md-2 p-1" name="docente_responsavel_id" id="uc-main-teacher-select" required>
                    <option value="">---</option>
                    @foreach ($docentes as $docente)
                    <option value="{{$docente->id}}" @selected($uc->docente_responsavel_id && $uc->docente_responsavel_id == $docente->id)>
                        {{$docente->numero_funcionario . ' - ' . $docente->user->nome}}
                    </option>
                    @endforeach
                </select>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="uc-teachers" class="col-md-2">Restantes Docentes</label>
                <div class="d-flex flex-column gap-2 col-md-6">
                    @foreach ($uc->docentes as $ucDocente)
                    @if ($ucDocente->id != $uc->docente_responsavel_id)
                    <select class="col-md-2 p-1" name="docentes_id[]">
                        <option value="">---</option>
                        @foreach ($docentes as $docente)
                        <option value="{{$docente->id}}" @selected($docente->id == $ucDocente->id)>
                            {{$docente->numero_funcionario . ' - ' . $docente->user->nome}}
                        </option>
                        @endforeach
                    </select>
                    @endif
                    @endforeach

                    @for ($i = 0; $i < 4-count($uc->docentes); $i++)
                        <select class="col-md-2 p-1" name="docentes_id[]">
                            <option value="">---</option>
                            @foreach ($docentes as $docente)
                            <option value="{{$docente->id}}">
                                {{$docente->numero_funcionario . ' - ' . $docente->user->nome}}
                            </option>
                            @endforeach
                        </select>
                    @endfor
                </div>
            </div>
            <div class="d-flex gap-3 mt-3 mb-5" id="form-btns">
                <input class="btn" type="submit" value="Submeter">
                <button class="btn" id="btn-delete">Remover</button>
                <a class="btn" href="{{route('admin.gerir.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</main>
@auth
<script>
    const authUser = @json(auth() -> user());
</script>
@endauth
<script src="{{asset('js/editUC.js')}}" defer></script>

@endsection