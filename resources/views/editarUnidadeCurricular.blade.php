@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['gerir dados', route('admin.gerir.view')]
        ]
    ])

    @include('partials._pageTitle', ['title' => $uc->nome . ' - ' . $uc->id])

    <section class="mt-3">
        <form id="edit-uc-form" action="" method="post" class="title-separator">
            <div class="mb-3">
                <input type="text" name="" id="" value="{{$uc->codigo}}" placeholder="Cód" required>
                <input type="text" name="" id="" value="{{$uc->nome}}" placeholder="Nome" required>
            </div>
            
            <fieldset>
                <div class="mb-2">
                    <label for="uc-area">Área Científica</label>
                    <select name="uc_area" id="uc_area" required>
                        <option value="" selected>Selecione</option>
                        @foreach($acns as $acn)
                        <option value="{{$acn->sigla}}">{{$acn->sigla}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="uc-ects">ECTSs</label>
                    <input type="number" name="uc_ects" id="uc-ects" value="{{$uc->ects}}" placeholder="Número de créditos" required>
                </div>
                <div class="mb-2">
                    <label for="uc-horas">Horas semanais</label>
                    <input type="number" name="uc_horas" id="uc-horas" value="{{$uc->horas_semanais}}" placeholder="Número de horas semais" required>
                </div>
                <div class="mb-2">
                    <label for="uc-main-teacher">Docente Responsável</label>
                    <select name="uc_main_teacher" id="uc-main-teacher" required>
                    <option value="" selected>Selecione</option>
                        @foreach($docentes as $docente)
                        <option value="{{$docente->numero_funcionario}}">{{$docente->numero_funcionario}} {{$docente->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    
                    <label for="uc-teachers">Restantes Docentes</label>
                    <div class="d-flex flex-column gap-2">
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            @foreach($docentes as $docente)
                            <option value="{{$docente->numero_funcionario}}">{{$docente->numero_funcionario}} {{$docente->nome}}</option>
                            @endforeach
                        </select>
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            @foreach($docentes as $docente)
                            <option value="{{$docente->numero_funcionario}}">{{$docente->numero_funcionario}} {{$docente->nome}}</option>
                            @endforeach
                        </select>
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            @foreach($docentes as $docente)
                            <option value="{{$docente->numero_funcionario}}">{{$docente->numero_funcionario}} {{$docente->nome}}</option>
                            @endforeach
                        </select>
                        <button class="btn">
                            Adicionar Docente
                        </button>
                    </div>
                </div>
            </fieldset>

            <div class="d-flex gap-3 mt-3 mb-5" id="form-btns">
                <input class="btn" type="button" value="Submeter">
                <input class="btn" type="button" value="Remover">
                <input class="btn" type="button" value="Cancelar">
            </div>

        </form>

    </section>

</main>
    
@endsection