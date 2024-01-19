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

    <section class="mt-3 title-separator">
        @include('partials._alerts')

        <form action="{{route('restricoes.update', ['id' => $uc->id])}}"  method="POST" id="restricao-form" class="mt-4">
            @csrf
            @method('PUT')
            @if ($aberto && !$permissao_editar)
            <div class="mb-4 bg-terciary p-1 px-2 border-1">
                <p>Apenas para efeitos de consulta. Contacte o docente responsável se deseja alterar as informações.</p>
            </div>
            @endif

            <div class="d-flex flex-column gap-3 mb-4">
                <fieldset >
                    <legend>Requisão de Laboratórios</legend>
                    <div class="col-md-3 d-flex justify-content-between">
                        <label for="aula-laboratorio-input">Sala de Aula</label>
                        <input type="checkbox" name="sala_laboratorio" id="aula-laboratorio-input"
                            @checked($uc->sala_laboratorio) @disabled(!$aberto || !$permissao_editar)>
                    </div>
                    <div class="col-md-3 d-flex justify-content-between">
                        <label for="exame-final-laboratorio">Exame Época Normal</label>
                        <input type="checkbox" name="exame_final_laboratorio" id="exame-final-laboratorio"
                            @checked($uc->exame_final_laboratorio) @disabled(!$aberto || !$permissao_editar)>
                    </div>
                    <div class="col-md-3 d-flex justify-content-between">
                        <label for="exame-recurso-laboratorio">Exame Época Recurso</label>
                        <input type="checkbox" name="exame_recurso_laboratorio" id="exame-recurso-laboratorio"
                            @checked($uc->exame_recurso_laboratorio) @disabled(!$aberto || !$permissao_editar)>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend>Observações sobre requisão de salas/laboratórios</legend>
                    <label class="d-none" for="observacoes-input">Observações</label>
                    <textarea class="px-2 py-1" name="observacoes" id="observacoes-input" cols="70" rows="5"
                        @disabled(!$aberto || !$permissao_editar)>{{$uc->observacoes_laboratorios}}</textarea>
                </fieldset>

                <fieldset>
                    <legend>Software necessário</legend>
                    <label class="d-block" for="software-necessario-input">Identifique nome, fabricante, versão e sistem operativo</label>
                    <textarea class="px-2 py-1" name="software" id="software-necessario-input" cols="90" rows="8"
                        @disabled(!$aberto || !$permissao_editar)>{{$uc->software}}</textarea>
                </fieldset>
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                <input class="btn" type="submit" value="Submeter" @if(!$aberto || !$permissao_editar) hidden @endif @disabled(!$aberto || !$permissao_editar)>
                @if (!$aberto || !$permissao_editar)
                    <a class="btn " href="{{route('restricoes.view')}}">Voltar</a>
                @else
                    <a class="btn cancelar" href="{{route('restricoes.view')}}">Cancelar</a>
                @endif
            </div>
        </form>
    </section>
</main>

<script src="{{asset('js/restricao.js')}}" defer></script>
@endsection