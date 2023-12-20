@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
    'crumbs' => [
    ['página inicial', '/inicio'],
    ['recolha', '/restricoes/submissao'],
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

                <fieldset id="justification-fieldset">
                    <h3>Justificação</h3>
                    <p>Para impedimentos, caso existam.</p>
                    <label class="d-block" for="justificacao"></label>
                    <textarea cols="30" name="justification" id="justificacao"></textarea>
                </fieldset>
                <div class="d-flex gap-3" id="form-btns">
                    <input class="btn" type="button" value="Submeter">
                    <input class="btn" type="button" value="Cancelar">
                </div>
            </form>
        </section>

        <section id="manage-uc-restrictions" class="tab-pane">
            <div class="d-flex p-3 gap-2 align-items-center">
                <!-- <i class="fa-solid fa-chevron-down"></i> -->
                <h3>Restrições de UC</h3>
            </div>
            <table class="w-100 shadow p-3 mb-5" id="table-forms-pendentes">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th></th>
                        <th scope="col-1">Ano</th>
                        <th scope="col-1">Semestre</th>
                        <th scope="col-1">Nome</th>
                        <th scope="col-1">Estado</th>
                        <th scope="col-1">Data Limite</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    <tr class="border border-light" data-type='restricao' data-start-year='2023' data-end-year='2024'
                        data-semester='1'>
                        <th scope='row'></th>
                        <td></td>
                        <td>7</td>
                        <td>1</td>
                        <td>MATI</td>
                        <td>Preenchido</td>
                        <td>31/12/2023</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="history" class="tab-pane">
            <div class="d-flex p-3 gap-2 align-items-center">

                <h3>Histórico</h3>
            </div>
            <table class="w-100 shadow p-3 mb-5" id="table-historico-formularios">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1">Ano</th>
                        <th scope="col-1">Semestre</th>
                        <th scope="col-1">Nome</th>
                        <th scope="col-1">Data Submissão</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    <tr data-type="impedimento" data-start-year="2023" data-end-year="2024" data-semester="1">
                        <th scope="row"></th>
                        <td>2022/23</td>
                        <td>1</td>
                        <td>Impedimentos de Horário</td>
                        <td>01/07/2023</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</main>

@endsection