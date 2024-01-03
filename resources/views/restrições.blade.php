@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['preencher restrições', route('restricoes.view')],
        ]
    ])

    @include('partials._pageTitle', ['title' => 'Recolha de restrições'])

    <section class="mt-5">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle='tab' data-bs-target='#manage-schedule'>
                    Impedimento de Horário
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#manage-uc-restrictions'>
                    Restrições de Unidade Curricular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#history'>
                    Histórico
                </button>
            </li>
        </ul>
    </section>

    <div class="tab-content pt-3">
        <section id="manage-schedule" class="tab-pane active">
            <form action="" method="post">
                <h3 class="p-3" >Horário semanal</h3>
                <p>Selecione todos os blocos para os quais <strong>não tem disponibilidade</strong>.
                    Mínimo de 2 blocos disponíveis
                </p>
                <div class="mb-5" id="schedule-grid">
                    <p></p>
                    <p>Segunda</p>
                    <p>Terça</p>
                    <p>Quarta</p>
                    <p>Quinta</p>
                    <p>Sexta</p>
                    <p>Sábado</p>

                    <p>Manhã</p>
                    <label for="segundaManha">
                        <input type="checkbox" name="monday_morning" id="segundaManha">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="tercaManha">
                        <input type="checkbox" name="tuesday_morning" id="tercaManha">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quartaManha">
                        <input type="checkbox" name="wednesday_morning" id="quartaManha">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quintaManha">
                        <input type="checkbox" name="thursday_morning" id="quintaManha">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sextaManha">
                        <input type="checkbox" name="friday_morning" id="sextaManha">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sabadoManha">
                        <input type="checkbox" name="saturday_morning" id="sabadoManha">
                        <i class="fa-solid fa-x"></i>
                    </label>

                    <p>Tarde</p>
                    <label for="segundaTarde">
                        <input type="checkbox" name="monday_afternoon" id="segundaTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="tercaTarde">
                        <input type="checkbox" name="tuesday_afternoon" id="tercaTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quartaTarde">
                        <input type="checkbox" name="wednesday_afternoon" id="quartaTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quintaTarde">
                        <input type="checkbox" name="thursday_afternoon" id="quintaTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sextaTarde">
                        <input type="checkbox" name="friday_afternoon" id="sextaTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sabadoTarde">
                        <input type="checkbox" name="saturday_afternoon" id="sabadoTarde">
                        <i class="fa-solid fa-x"></i>
                    </label>

                    <p>Noite</p>
                    <label for="segundaNoite">
                        <input type="checkbox" name="monday_night" id="segundaNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="tercaNoite">
                        <input type="checkbox" name="tuesday_night" id="tercaNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quartaNoite">
                        <input type="checkbox" name="wednesday_night" id="quartaNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="quintaNoite">
                        <input type="checkbox" name="thursday_night" id="quintaNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sextaNoite">
                        <input type="checkbox" name="friday_night" id="sextaNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <label for="sabadoNoite">
                        <input type="checkbox" name="saturday_night" id="sabadoNoite">
                        <i class="fa-solid fa-x"></i>
                    </label>
                </div>

                <fieldset id="justification-fieldset" class="mb-5">
                    <h3>Justificação</h3>
                    <p>Para impedimentos, caso existam.</p>
                    <label class="d-block" for="justificacao"></label>
                    <textarea cols="60" rows="8" name="justification" id="justificacao" class="px-2 py-1"></textarea>
                </fieldset>

                <div class="d-flex gap-3" id="form-btns">
                    <input class="btn" type="button" value="Submeter">
                    <input class="btn" type="button" value="Cancelar">
                </div>
            </form>
        </section>

        <section id="manage-uc-restrictions" class="tab-pane">
            <div class="d-flex p-3 gap-2 align-items-center">
                <h3>Restrições de UCs {{$periodo->ano . '/' . ($periodo->ano+1 . ' ' . $periodo->semestre . 'º semestre')}}</h3>
            </div>
            <table class="w-100 shadow p-3 mb-5" id="table-restricoes-pendentes">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1">Nome</th>
                        <th scope="col-1">Estado</th>
                        <th scope="col-1">Data Limite</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                @foreach($ucs as $uc)
                    <tr class="border border-light" data-ano='{{$uc->periodo->ano}}' data-semestre='{{$uc->periodo->semestre}}' data-uc-id='{{$uc->id}}'>
                        <th scope='row'></th>
                        <td>{{$uc->nome}}</td>
                        <td>{{$uc->restricoes_submetidas ? 'Submetido' : 'Pendente'}}</td>
                        <td>{{$uc->periodo->data_final}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <section id="history" class="tab-pane">
            <div class="d-flex p-3 gap-2 align-items-center">
                <h3>Histórico de Impedimentos</h3>
            </div>
            <table class="w-100 shadow p-3 mb-5" id="table-impedimentos-historico">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1">Ano</th>
                        <th scope="col-1">Semestre</th>
                        <th scope="col-1">Nome do docente</th>
                        <th scope="col-1">Data Submissão</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    @foreach($historico_impedimentos as $impedimento)
                    <tr data-ano="{{$impedimento->periodo->ano}}" data-semestre="{{$impedimento->periodo->semestre}}">
                        <th scope="row"></th>
                        <td>{{$impedimento->periodo->ano}}</td>
                        <td>{{$impedimento->periodo->semestre}}</td>
                        <td>{{$impedimento->docente->user->nome}}</td>
                        <td>{{$impedimento->periodo->data_final}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex p-3 gap-2 align-items-center">

                <h3>Histórico de Restrições</h3>
            </div>
            <table class="w-100 shadow p-3 mb-5" id="table-restricoes-historico">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1">Ano</th>
                        <th scope="col-1">Semestre</th>
                        <th scope="col-1">Nome da UC</th>
                        <th scope="col-1">Data Submissão</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    @foreach($historico_ucs as $uc)
                    <tr data-ano="{{$uc->periodo->ano}}" data-semestre="{{$uc->periodo->semestre}}" data-uc-id="{{$uc->id}}">
                        <th scope="row"></th>
                        <td>{{$uc->periodo->ano}}</td>
                        <td>{{$uc->periodo->semestre}}</td>
                        <td>{{$uc->nome}}</td>
                        <td>{{$uc->periodo->data_final}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</main>

@auth
    <script>
        const authUser = @json(auth()->user());
    </script>
@endauth
<script src="{{asset('js/restricoes.js')}}" defer></script>
@endsection