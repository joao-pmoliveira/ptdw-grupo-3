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
                <p></p>
                <p>Segunda</p>
                <p>Terça</p>
                <p>Quarta</p>
                <p>Quinta</p>
                <p>Sexta</p>
                <p>Sábado</p>

                <p>Manhã</p>
                <label for="segundaManha">
                    <input type="checkbox" name="monday_morning" id="segundaManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaManha">
                    <input type="checkbox" name="tuesday_morning" id="tercaManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaManha">
                    <input type="checkbox" name="wednesday_morning" id="quartaManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaManha">
                    <input type="checkbox" name="thursday_morning" id="quintaManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaManha">
                    <input type="checkbox" name="friday_morning" id="sextaManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoManha">
                    <input type="checkbox" name="saturday_morning" id="sabadoManha" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>

                <p>Tarde</p>
                <label for="segundaTarde">
                    <input type="checkbox" name="monday_afternoon" id="segundaTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaTarde">
                    <input type="checkbox" name="tuesday_afternoon" id="tercaTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaTarde">
                    <input type="checkbox" name="wednesday_afternoon" id="quartaTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaTarde">
                    <input type="checkbox" name="thursday_afternoon" id="quintaTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaTarde">
                    <input type="checkbox" name="friday_afternoon" id="sextaTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoTarde">
                    <input type="checkbox" name="saturday_afternoon" id="sabadoTarde" @disabled($editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>

                <p>Noite</p>
                <label for="segundaNoite">
                    <input type="checkbox" name="monday_night" id="segundaNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="tercaNoite">
                    <input type="checkbox" name="tuesday_night" id="tercaNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quartaNoite">
                    <input type="checkbox" name="wednesday_night" id="quartaNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="quintaNoite">
                    <input type="checkbox" name="thursday_night" id="quintaNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sextaNoite">
                    <input type="checkbox" name="friday_night" id="sextaNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
                <label for="sabadoNoite">
                    <input type="checkbox" name="saturday_night" id="sabadoNoite" @disabled(!$editavel)>
                    <i class="fa-solid fa-x"></i>
                </label>
            </div>

            <fieldset id="justification-fieldset" class="mb-5">
                <h3>Justificação</h3>
                <p>Para impedimentos, caso existam.</p>
                <label class="d-block" for="justificacao"></label>
                <textarea cols="60" rows="8" name="justification" id="justificacao" class="px-2 py-1" @disabled(!$editavel)>
                </textarea>
            </fieldset>

            <div class="d-flex gap-3" id="form-btns">
                <input class="btn" type="button" value="Submeter" @disabled(!$editavel)>
                <input class="btn" type="button" value="Cancelar">
            </div>
        </form>
    </section>
</main>

@endsection