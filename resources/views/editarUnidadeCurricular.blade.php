@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', '/inicio'],
            ['unidades curriculares', '/ucs']
        ]
    ])

    @include('partials._pageTitle', ['title' => 'Unidade Curricular '.$id])

    <section class="mt-5">
        <form id="edit-uc-form" action="" method="post" class="title-separator">
            <div class="mb-3">
                <input type="text" name="" id="" value="" placeholder="Cód" required>
                <input type="text" name="" id="" value="" placeholder="Nome" required>
            </div>
            
            <fieldset>
                <div>
                    <label for="uc-area">Área Científica</label>
                    <select name="uc_area" id="uc_area" required>
                        <option value="" selected>Selecione</option>
                        <option value="Eng_mecanica">Engenharia Mecânica</option>
                        <option value="ciencias_informaticas">Ciências Informáticas</option>
                        <option value="ciencias_sociais">Ciências Sociais</option>
                    </select>
                </div>
                <div>
                    <label for="uc-ects">ECTSs</label>
                    <input type="number" name="uc_ects" id="uc-ects" value="5" placeholder="Número de créditos" required>
                </div>
                <div>
                    <label for="uc-horas">Horas semanais</label>
                    <input type="number" name="uc_horas" id="uc-horas" value="4" placeholder="Número de horas semais" required>
                </div>
                <div>
                    <label for="uc-main-teacher">Docente Responsável</label>
                    <select name="uc_main_teacher" id="uc-main-teacher" required>
                        <option value="" selected>Selecione</option>
                        <option value="110111">110111 José Silva</option>
                        <option value="101555">101555 Rita Gonçalves</option>
                        <option value="106221">106221 Luísa Mendes</option>
                    </select>
                </div>
                <div>
                    
                    <label for="uc-teachers">Restantes Docentes</label>
                    <div class="d-flex flex-column gap-2">
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            <option value="110111">110111 José Silva</option>
                            <option value="101555">101555 Rita Gonçalves</option>
                            <option value="106221">106221 Luísa Mendes</option>
                        </select>
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            <option value="110111">110111 José Silva</option>
                            <option value="101555">101555 Rita Gonçalves</option>
                            <option value="106221">106221 Luísa Mendes</option>
                        </select>
                        <select name="uc_teachers" id="uc-teachers">
                            <option value="" selected>Selecione</option>
                            <option value="110111">110111 José Silva</option>
                            <option value="101555">101555 Rita Gonçalves</option>
                            <option value="106221">106221 Luísa Mendes</option>
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