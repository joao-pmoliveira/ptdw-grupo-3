@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['preencher restrições', route('restricoes.view')],
        ]
    ])

    @include('partials._pageTitle', ['title' => 'Preencher restrições'])

    @include('partials._alerts')

    <section class="mt-3">
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

    <div class="tab-content">
        <section id="manage-schedule" class="tab-pane active p-3">
            @if ($impedimento)
            
            @php
                $dias = explode(';', $impedimento->impedimentos);
                $segunda = explode(',', $dias[0]);
                $terca = explode(',', $dias[1]);
                $quarta = explode(',', $dias[2]);
                $quinta = explode(',', $dias[3]);
                $sexta = explode(',', $dias[4]);
                $sabado = explode(',', $dias[5]);

                $ultimoDias = explode(';', $historico_impedimentos[0]['impedimentos']);
                $ultimasegunda = explode(',', $ultimoDias[0]);
                $ultimaterca = explode(',', $ultimoDias[1]);
                $ultimaquarta = explode(',', $ultimoDias[2]);
                $ultimaquinta = explode(',', $ultimoDias[3]);
                $ultimasexta = explode(',', $ultimoDias[4]);
                $ultimasabado = explode(',', $ultimoDias[5]);
            @endphp
            <form action="{{route('impedimentos.update', ['id' => $impedimento->id])}}" method="POST" id="impedimento-form">
                @csrf
                @method('PUT')
                <fieldset class="mb-5">
                    <h3 class="">Horário semanal</h3>
                    <p class="mb-2">Selecione todos os blocos para os quais <strong>não tem disponibilidade</strong>.
                        Mínimo de 2 blocos disponíveis
                    </p>
    
                    @if ($historico_impedimentos[0])
                        <div class="form-check p-0">
                            <label class="form-check-label" for="ultimoImpedimento">
                                Preencher com impedimento anterior
                            </label>
                            <input class="form-check-input" type="checkbox" name="ultimoImpedimento" id="ultimoImpedimento">
                          </div>
                    @endif

                    <div class="mb-2" id="schedule-grid">
                        <p></p>
                        <p>Segunda</p>
                        <p>Terça</p>
                        <p>Quarta</p>
                        <p>Quinta</p>
                        <p>Sexta</p>
                        <p>Sábado</p>
    
                        <p>Manhã</p>
                        <label for="segunda-manha-input">
                            <input type="checkbox" name="segunda_manha" data-history="{{$ultimasegunda[0]}}" id="segunda-manha-input" @checked($segunda[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="terca-manha-input">
                            <input type="checkbox" name="terca_manha" data-history="{{$ultimaterca[0]}}" id="terca-manha-input" @checked($terca[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quarta-manha-input">
                            <input type="checkbox" name="quarta_manha" data-history="{{$ultimaquarta[0]}}" id="quarta-manha-input" @checked($quarta[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quinta-manha-input">
                            <input type="checkbox" name="quinta_manha" data-history="{{$ultimaquinta[0]}}"  id="quinta-manha-input" @checked($quinta[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sexta-manha-input">
                            <input type="checkbox" name="sexta_manha" data-history="{{$ultimasexta[0]}}" id="sexta-manha-input" @checked($sexta[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sabado-manha-input">
                            <input type="checkbox" name="sabado_manha" data-history="{{$ultimasabado[0]}}" id="sabado-manha-input" @checked($sabado[0])>
                            <i class="fa-solid fa-x"></i>
                        </label>
    
                        <p>Tarde</p>
                        <label for="segunda-tarde-input">
                            <input type="checkbox" name="segunda_tarde" data-history="{{$ultimasegunda[1]}}" id="segunda-tarde-input" @checked($segunda[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="terca-tarde-input">
                            <input type="checkbox" name="terca_tarde" data-history="{{$ultimaterca[1]}}" id="terca-tarde-input" @checked($terca[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quarta-tarde-input">
                            <input type="checkbox" name="quarta_tarde" data-history="{{$ultimaquarta[1]}}" id="quarta-tarde-input" @checked($quarta[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quinta-tarde-input">
                            <input type="checkbox" name="quinta_tarde" data-history="{{$ultimaquinta[1]}}" id="quinta-tarde-input" @checked($quinta[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sexta-tarde-input">
                            <input type="checkbox" name="sexta_tarde" data-history="{{$ultimasexta[1]}}" id="sexta-tarde-input" @checked($sexta[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sabado-tarde-input">
                            <input type="checkbox" name="sabado_tarde" data-history="{{$ultimasabado[1]}}" id="sabado-tarde-input" @checked($sabado[1])>
                            <i class="fa-solid fa-x"></i>
                        </label>
    
                        <p>Noite</p>
                        <label for="segunda-noite-input">
                            <input type="checkbox" name="segunda_noite" data-history="{{$ultimasegunda[2]}}" id="segunda-noite-input" @checked($segunda[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="terca-noite-input">
                            <input type="checkbox" name="terca_noite" data-history="{{$ultimaterca[2]}}" id="terca-noite-input" @checked($terca[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quarta-noite-input">
                            <input type="checkbox" name="quarta_noite" data-history="{{$ultimaquarta[2]}}" id="quarta-noite-input" @checked($quarta[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="quinta-noite-input">
                            <input type="checkbox" name="quinta_noite" data-history="{{$ultimaquinta[2]}}" id="quinta-noite-input" @checked($quinta[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sexta-noite-input">
                            <input type="checkbox" name="sexta_noite" data-history="{{$ultimasexta[2]}}" id="sexta-noite-input" @checked($sexta[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                        <label for="sabado-noite-input">
                            <input type="checkbox" name="sabado_noite" data-history="{{$ultimasabado[2]}}" id="sabado-noite-input" @checked($sabado[2])>
                            <i class="fa-solid fa-x"></i>
                        </label>
                    </div>

                    <div class="d-none" id="schedule-grid-error">
                        <p class="text-alert fw-bold">*Manter pelo menos DOIS blocos livres!</p>
                    </div>
                </fieldset>

                <fieldset id="justification-fieldset" class="mb-4">
                    <h3>Justificação</h3>
                    <p class="mb-2">Para impedimentos, caso existam.</p>
                    <label class="d-block" for="justicacao-input"></label>
                    <textarea data-history="{{$historico_impedimentos[0]['justificacao']}}" cols="60" rows="8" name="justificacao" id="justificao-input" class="px-2 py-1">{{$impedimento->justificacao}}</textarea>
                    <div class="d-none" id="justification-error">
                        <p class="text-alert fw-bold">*Justifica obrigatória</p>
                    </div>
                </fieldset>

                <div class="d-flex gap-3" id="form-btns">
                    <input class="btn" type="submit" value="Submeter">
                    <a class="btn cancelar" href="{{route('inicio.view')}}">Cancelar</a>
                    <input class="btn" type="reset" value="Reset">
                </div>
            </form>
            @else
            <h3>Sem formulário aberto</h3>
            @endif
        </section>

        <section id="manage-uc-restrictions" class="tab-pane p-3">
            
            <h3 class="mb-2">
                Restrições de UCs {{$periodo->ano}}/{{$periodo->ano+1}} - {{$periodo->semestre}} º semestre
            </h3>

            <table class="w-100 shadow" id="table-restricoes-pendentes">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col-1">Nome</th>
                        <th scope="col-1">Estado</th>
                        <th scope="col-1">Data Limite</th>
                    </tr>
                </thead>
                <tbody class="title-separator">
                    @if ($ucs->count() > 0)
                    @foreach($ucs as $uc)
                        <tr class="border border-light" 
                        data-link="{{route('restricoes.uc.view', ['uc'=>$uc->id, 'ano_inicial'=>$periodo->ano, 'semestre'=>$periodo->semestre])}}">
                            <th scope='row'></th>
                            <td>{{$uc->nome}}</td>
                            <td>
                                @if ($uc->restricoes_submetidas)
                                    <i class="fa fa-check"></i>
                                @else
                                    Pendente
                                @endif
                            </td>
                            <td>{{$uc->periodo->data_final}}</td>
                        </tr>
                    @endforeach
                    @else 
                        <tr class="border border-light pe-none">
                            <th scope="row"></th>
                            <td colspan="4">Sem correspondências</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </section>

        <section id="history" class="tab-pane p-3">
            <h3 class="mb-2">Histórico de Impedimentos</h3>
            <table class="w-100 shadow mb-5" id="table-impedimentos-historico">
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
                    @if ($historico_impedimentos->count() > 0)
                    @foreach($historico_impedimentos as $impedimento)
                        <tr data-link="{{route('impedimentos.view', ['docente'=>$user->docente->id, 'ano_inicial'=>$impedimento->periodo->ano, 'semestre'=>$impedimento->periodo->semestre])}}">
                            <th scope="row"></th>
                            <td>{{$impedimento->periodo->ano}}</td>
                            <td>{{$impedimento->periodo->semestre}}</td>
                            <td>{{$impedimento->docente->user->nome}}</td>
                            <td>{{$impedimento->periodo->data_final}}</td>
                        </tr>
                    @endforeach
                    @else
                        <tr class="border border-light pe-none">
                            <th scope="row"></th>
                            <td colspan="4">Sem correspondências</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <h3 class="mb-2">Histórico de Restrições</h3>
            <table class="w-100 shadow mb-5" id="table-restricoes-historico">
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
                    @if ($historico_ucs->count() > 0)
                    @foreach($historico_ucs as $uc)
                    <tr data-link="{{route('restricoes.uc.view', ['uc'=>$uc->id, 
                    'ano_inicial'=>$uc->periodo->ano,'semestre'=>$uc->periodo->semestre])}}">
                        <th scope="row"></th>
                        <td>{{$uc->periodo->ano}}</td>
                        <td>{{$uc->periodo->semestre}}</td>
                        <td>{{$uc->nome}}</td>
                        <td>{{$uc->periodo->data_final}}</td>
                    </tr>
                    @endforeach 
                    @else
                        <tr class="border border-light pe-none">
                            <th scope="row"></th>
                            <td colspan="4">Sem correspondências</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </section>
    </div>
</main>

<script>
    window.onload = () => window.scrollTo(0,0);
</script>
<script src="{{asset('js/restricoes.js')}}" defer></script>
@endsection