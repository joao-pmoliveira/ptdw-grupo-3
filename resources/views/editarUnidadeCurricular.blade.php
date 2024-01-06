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
        <form id="edit-uc-form" action="{{route('ucs.update', ['id' => $uc->id])}}" class="title-separator">
        @csrf
            <div class="mb-3">
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-codigo">Código</label>
                <input class="col-md-2 p-1" type="text" name="uc-codigo" id="uc-codigo-input" value="{{$uc->codigo}}" placeholder="Cód" required>
            </div>
            
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-nome">Nome</label>
                <input class="col-md-6 p-1" type="text" name="uc-nome" id="uc-nome-input" value="{{$uc->nome}}" placeholder="Nome" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-acn">Área Científica</label>
                <select class="col-md-2 p-1" name="uc-acn" id="uc-acn-select" required>
                    <option value="{{$uc->acn_id}}" selected>{{$uc->sigla}}</option>
                    @foreach ($acns as $acn)
                        <option value="{{$acn->sigla}}">{{$acn->sigla}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-ects">ECTS</label>
                <input class="col-md-2 p-1" type="number" name="uc-ects" id="uc-ects-input" value="{{$uc->ects}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-horas">Horas Semanais</label>
                <input class="col-md-2 p-1" type="number" name="uc-horas" id="uc-horas-input" value="{{$uc->horas_semanais}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-main-teacher">Docente Responsável</label>
                <select class="col-md-2 p-1" name="uc-main-teacher" id="uc-main-teacher-select" required>
                        <option value="{{$uc->docenteResponsavel->numero_funcionario}}" selected> {{$uc->docenteResponsavel->numero_funcionario .' - '. $uc->docenteResponsavel->user->nome}} </option>
                    @foreach ($docentes as $docente)
                        <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}</option>   
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label class="col-md-2 p-3" for="uc-teachers">Restantes Docentes</label>
                <div class="d-flex flex-column gap-2 col-md-4 p-1">
                @php
                    $docentesCount = count($uc->docentes);
                @endphp
                    @for ($i = 1; $i < count($uc->docentes)+1 ; $i++)
                        @foreach ( $uc->docentes as $docente)
                        <select name="uc-teachers" id="uc-teachers-select-{{$i}}">
                            <option value="{{$docente->numero_funcionario}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}</option>
                            @foreach($docentes as $docente)
                                <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}</option>
                            @endforeach
                        </select>
                        @endforeach
                    @endfor
                    @for ($i = count($uc->docentes)+1 ; $i < 5; $i++)
                        @foreach ( $uc->docentes as $docente)
                        <select name="uc-teachers" id="uc-teachers-select-{{$i}}">
                            <option value="">Selecione</option> 
                            @foreach($docentes as $docente)
                                <option value="{{$docente->id}}">{{$docente->numero_funcionario .' - '. $docente->user->nome}}</option>
                            @endforeach
                        </select>
                        @endforeach
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
        const authUser = @json(auth()->user());
    </script>
@endauth
<script src="{{asset('js/editUC.js')}}" defer></script>
    
@endsection