@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', '/inicio'],
                    ['preencher restrições', '/restricoes'],
                    ['impedimentos de horário',
                        route('impedimentos.view', [
                            'docente' => $docente,
                            'ano_inicial'=>$ano_inicial,
                            'semestre' => $semestre])]
                ]
        ])
    
    @include('partials._pageTitle', ['title' => 'Impedimentos de Horário '.$ano_inicial.'/'.($ano_inicial+1).' '.$semestre.'º Semestre'])

    <section class="mt-5">
        <form action="" method="post">
            <h3 class="p-3" >Horário semanal</h3>
            <p>Selecione todos os blocos para os quais <strong>não tem disponibilidade</strong>.
                Mínimo de 2 blocos disponíveis
            </p>
            <div class="mb-5" id="schedule-grid">

                @php
                    $dias = explode(';', $impedimento->impedimentos);
                    $segunda = explode(',', $dias[0]);
                    $terca = explode(',', $dias[1]);
                    $quarta = explode(',', $dias[2]);
                    $quinta = explode(',', $dias[3]);
                    $sexta = explode(',', $dias[4]);
                    $sabado = explode(',', $dias[5]);
                @endphp

                <p></p>
                <p>Segunda</p>
                <p>Terça</p>
                <p>Quarta</p>
                <p>Quinta</p>
                <p>Sexta</p>
                <p>Sábado</p>

                <p>Manhã</p>
                <label for="segundaManha">
                    <input type="checkbox" name="monday_morning" id="segundaManha" @checked($segunda[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaManha">
                    <input type="checkbox" name="tuesday_morning" id="tercaManha" @checked($terca[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaManha">
                    <input type="checkbox" name="wednesday_morning" id="quartaManha" @checked($quarta[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaManha">
                    <input type="checkbox" name="thursday_morning" id="quintaManha" @checked($quinta[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaManha">
                    <input type="checkbox" name="friday_morning" id="sextaManha" @checked($sexta[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoManha">
                    <input type="checkbox" name="saturday_morning" id="sabadoManha" @checked($sabado[0]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>

                <p>Tarde</p>
                <label for="segundaTarde">
                    <input type="checkbox" name="monday_afternoon" id="segundaTarde" @checked($segunda[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaTarde">
                    <input type="checkbox" name="tuesday_afternoon" id="tercaTarde" @checked($terca[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaTarde">
                    <input type="checkbox" name="wednesday_afternoon" id="quartaTarde" @checked($quarta[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaTarde">
                    <input type="checkbox" name="thursday_afternoon" id="quintaTarde" @checked($quinta[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaTarde">
                    <input type="checkbox" name="friday_afternoon" id="sextaTarde" @checked($sexta[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoTarde">
                    <input type="checkbox" name="saturday_afternoon" id="sabadoTarde" @checked($sabado[1]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>

                <p>Noite</p>
                <label for="segundaNoite">
                    <input type="checkbox" name="monday_night" id="segundaNoite" @checked($segunda[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaNoite">
                    <input type="checkbox" name="tuesday_night" id="tercaNoite" @checked($terca[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaNoite">
                    <input type="checkbox" name="wednesday_night" id="quartaNoite" @checked($quarta[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaNoite">
                    <input type="checkbox" name="thursday_night" id="quintaNoite" @checked($quinta[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaNoite">
                    <input type="checkbox" name="friday_night" id="sextaNoite" @checked($sexta[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoNoite">
                    <input type="checkbox" name="saturday_night" id="sabadoNoite" @checked($sabado[2]) @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
            </div>

            <fieldset id="justification-fieldset" class="mb-5">
                <h3>Justificação</h3>
                <p>Para impedimentos, caso existam.</p>
                <label class="d-block" for="justificacao"></label>
                <textarea cols="60" rows="8" name="justification" id="justificacao" class="px-2 py-1"  @disabled(!$editavel)>{{$impedimento->justificacao}}</textarea>
            </fieldset>

            <div class="d-flex gap-3" id="form-btns">
                <input class="btn" type="button" value="Submeter" @if(!$editavel)hidden @endif @disabled(!$editavel)>
                
                    @if (!$editavel)
                        <a class="btn" href="{{route('restricoes.view')}}">Voltar</a>
                    @else
                        <a class="btn cancelar" href="{{route('restricoes.view')}}">Cancelar</a>
                    @endif
                
            </div>
        </form>
    </section>
</main>
<script>
    var baseUrl = "{{ config('app.url') }}";
</script>

@endsection