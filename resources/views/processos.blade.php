@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', route('inicio.view')],
                ['recolha de restrições', route('restricoes.recolha.view')]
            ]
    ])

    @include('partials._pageTitle', ['title' => $page_title])

    <section class="mt-5 p-0 d-flex flex-column gap-4">
        <div class="d-flex gap-2 align-items-center" data-bs-toggle="collapse" data-bs-target="#table">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Formulário em progresso</h3>
        </div>
        <table class="accordion table-ua collapse accordion-collapse title-separator show" id="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1"></th>
                    <th scope="col-4">Nome</th>
                    <th scope="col-1">Data Limite</th>
                    <th scope="col-1" style="text-align:center;">Restrições UC</th>
                    <th scope="col-1" style="text-align:center;">Impedimentos horários</th>
                    <th scope="col-1"></th>
                    <th scope="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <!--Linha Principal-->
                <tr data-bs-toggle="collapse" data-bs-target="#r2">
                    <th scope="row"></th>
                    <td><i class="fa-solid fa-chevron-right"></i></td>
                    <td>{{'Formulário ' . $periodo->ano . '/' . ($periodo->ano + 1) . ' ' . $periodo->semestre . 'ºSemestre'}}</td>
                    <td>{{$periodo->data_final}}</td>
                    <td style="text-align:center;">3/4</td>
                    <td style="text-align:center;">1/2</td>
                    <td><i class="fa-solid fa-download"></i></td>
                    <td><i class="fa-solid fa fa-envelope-o"></i></td>
                </tr>
                <!--Linha Colapsável-->
                @foreach($docentes as $docente)
                <tr class="collapse accordion-collapse bg-terciary" id="r2">
                    <th scope='row'></th>
                    <td colspan='1'>{{$docente->numero_funcionario}}</td>
                    <td colspan='2'>{{$docente->user->nome}}</td>
                    <td colspan='1' style="text-align:center;">{{
                        $docente->ucResponsavel 
                            ? $docente->ucResponsavel->restricoes_submetidas . '/' . (bool)$docente->ucResponsavel 
                            : 'Não é docente responsável'
                    }}</td>
                    <td colspan='2' style="text-align:center;">{{$docente->impedimentos()->where('periodo_id' , $periodo->id)->first()->submetido?'Submetido' : 'Pendente'}}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <p class="mb-1">Nenhum formulário ativo de momento.</p>
            <button class="btn"
                    data-bs-toggle="modal" data-bs-target="#modal-new-process"
                    >Gerar formulário</button>
        </div>
    </section>


    <section class="mt-5 p-0 d-flex flex-column gap-4">
        
        <hr>
        <div class="d-flex gap-2 align-items-center" data-bs-toggle="collapse" data-bs-target="#history-table">
            <i class="fa-solid fa-chevron-down"></i>
            <h3>Histórico</h3>
        </div>
        <table class="accordion table-ua collapse accordion-collapse title-separator" id="history-table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col-1"></th>
                    <th scope="col-4">Nome</th>
                    <th scope="col-1">Data Limite</th>
                    <th scope="col-1" style="text-align:center;">Restrições UC</th>
                    <th scope="col-1" style="text-align:center;">Impedimentos horários</th>
                    <th scope="col-1"></th>
                    <th scope="col-1"></th>
                </tr>
            </thead>
            <tbody>
                <!--Linha Principal--> 
                @foreach($periodosH as $periodoH)
                <tr data-bs-toggle="collapse" data-bs-target="#r1">
                    <th scope='row'></th>
                    <td ><i class="fa-solid fa-chevron-right"></i></td>
                    <td>{{'Formulário ' . $periodoH->ano . '/' . ($periodoH->ano + 1) . ' ' . $periodoH->semestre . 'ºSemestre'}}</td>
                    <td>{{$periodoH->data_final}}</td>
                    <td style="text-align:center;">4/4</td>
                    <td style="text-align:center;">2/2</td>
                    <td><i class="fa-solid fa-download"></i></td>
                </tr>
                    @foreach($docentes as $docente)
                    <tr class="collapse accordion-collapse bg-terciary" id="r2">
                        <th scope='row'></th>
                        <td colspan='1'>{{$docente->numero_funcionario}}</td>
                        <td colspan='2'>{{$docente->user->nome}}</td>
                        <td colspan='1' style="text-align:center;">{{
                            $docente->ucResponsavel 
                                ? $docente->ucResponsavel->restricoes_submetidas . '/' . (bool)$docente->ucResponsavel 
                                : 'Não é docente responsável'
                        }}</td>
                        <td colspan='2' style="text-align:center;">{{$docente->impedimentos()->where('periodo_id' , $periodo->id)->first()->submetido?'Submetido' : 'Pendente'}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </section>

    <div class="modal fade" id="modal-new-process" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-0">
            <div class="modal-body d-flex flex-column gap-3 px-5 py-4">
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="school-year">Ano Letivo:</label>
                    <input class="w-50" type="text" name="school_year" id="school-year">
                </div>
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="semester">Semestre:</label>
                    <input class="w-50" type="number" name="semester" id="semester" min="1" max="2">
                </div>
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <label class="w-50" for="due-date">Data Limite:</label>
                    <input class="w-50" type="date" name="due_date" id="due-date">
                </div>
                <div class="d-flex gap-3 justify-content-center" id="form-btns">
                    <input class="btn" type="button" value="Submeter">
                    <input class="btn" data-bs-dismiss="modal" type="button" value="Cancelar">
                </div>
            </div>
        </div>

        </div>
    </div>

</main>
@endsection