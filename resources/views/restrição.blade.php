@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', route('inicio.view')],
                    ['preencher restrições', route('restricoes.view')],
                    ['restrições de '.strtolower($uc->nome), route('restricoes.uc.view', [
                        'uc' => $uc->id,
                        'ano_inicial' => $ano_inicial,
                        'semestre' => $semestre])]
                ]
        ])

    @include('partials._pageTitle', ['title' => 'Restrições de '. $uc->nome. ' - '.$ano_inicial.'/'. ($ano_inicial+1).' - '.$semestre.'º Semestre'])

    <section class="mt-3">
        <form action="{{route('restricoes.update', ['id' => $uc->id])}}"  method="POST" id="restricao-form">
            @csrf
            @method('PUT')
            <div class="title-separator d-flex flex-column gap-3 py-4">
                @if($editavel && $ultimaRestricao_uc)
                    <div class="form-check p-0">
                        <label class="form-check-label" for="ultimaRestricao">
                            Preencher com restrição anterior
                        </label>
                        <input class="form-check-input" type="checkbox" name="ultimaRestricao" id="ultimaRestricao">
                    </div>
                @endif
                <fieldset>
                    <legend>Requisão de Laboratórios</legend>
                    <div class="col-md-3 form-check p-0 d-flex justify-content-between">
                        <label class="form-check-label" for="aula-laboratorio-input">Sala de Aula</label>
                        <input class="form-check-input" type="checkbox" data-history="{{$ultimaRestricao_uc->sala_laboratorio}}" name="sala_laboratorio" id="aula-laboratorio-input"
                            @checked($uc->sala_laboratorio) @disabled(!$editavel)>
                    </div>
                    <div class="col-md-3 form-check p-0 d-flex justify-content-between">
                        <label class="form-check-label" for="exame-final-laboratorio">Exame Época Normal</label>
                        <input class="form-check-input" type="checkbox" data-history="{{$ultimaRestricao_uc->exame_final_laboratorio}}" name="exame_final_laboratorio" id="exame-final-laboratorio"
                            @checked($uc->exame_final_laboratorio) @disabled(!$editavel)>
                    </div>
                    <div class="col-md-3 form-check p-0 d-flex justify-content-between">
                        <label class="form-check-label" for="exame-recurso-laboratorio">Exame Época Recurso</label>
                        <input class="form-check-input" type="checkbox" data-history="{{$ultimaRestricao_uc->exame_recurso_laboratorio}}"  name="exame_recurso_laboratorio" id="exame-recurso-laboratorio"
                            @checked($uc->exame_recurso_laboratorio) @disabled(!$editavel)>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend>Observações sobre requisão de salas/laboratórios</legend>
                    <label class="d-none" for="observacoes-input">Observações</label>
                    <textarea class="px-2 py-1" data-history="{{$ultimaRestricao_uc->observacoes_laboratorios}}" name="observacoes" id="observacoes-input" cols="70" rows="5"
                        @disabled(!$editavel)>{{$uc->observacoes_laboratorios}}</textarea>
                </fieldset>

                <fieldset>
                    <legend>Software necessário</legend>
                    <label class="d-block" for="software-necessario-input">Identifique nome, fabricante, versão e sistem operativo</label>
                    <textarea class="px-2 py-1" data-history="{{$ultimaRestricao_uc->software}}" name="software" id="software-necessario-input" cols="90" rows="8"
                        @disabled(!$editavel)>{{$uc->software}}</textarea>
                </fieldset>
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                @if($editavel)
                    <input class="btn" type="submit" value="Submeter" @disabled(!$editavel)>
                    <a class="btn cancelar" href="{{route('restricoes.view')}}" value="Cancelar">Cancelar</a>
                    <input class="btn" type="reset" value="Reset">
                @elseif(!$editavel)
                    <a class="btn cancelar" href="{{route('restricoes.view')}}" value="Cancelar">Cancelar</a>
                @endif
            </div>
        </form>
    </section>
</main>

@auth
    <script>
        const authUser = @json(auth()->user());
        var baseUrl = "{{ config('app.url') }}";
    </script>
@endauth
<script src="{{asset('js/restricao.js')}}" defer></script>
@endsection