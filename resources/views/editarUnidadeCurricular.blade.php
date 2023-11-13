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
        <form id="edit-uc-form" action="" method="post">
            <div class="mb-3">
                <input type="text" name="" id="" value="" placeholder="Cód" required>
                <input type="text" name="" id="" value="" placeholder="Nome" required>
            </div>
            
            <fieldset>
                <div>
                    <label for="uc-department">Departamento</label>
                    <input type="text" name="uc_department" id="uc-department" value="dmat" placeholder="Insira o departamento" required>
                </div>
                <div>
                    <label for="uc-area">Área Científica</label>
                    <input type="text" name="uc_area" id="uc-area" value="Matemática" placeholder="Insira a área de ensino" required>
                </div>
                <div>
                    <label for="uc-ects">ECTs</label>
                    <input type="number" name="uc_ects" id="uc-ects" value="5" placeholder="Número de créditos" required>
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
                        <button class="m-0 py-2 px-3
                            btn btn-primary rounded-0
                            border border-primary
                            btn-outline-0
                            shadow-none
                            text-primary button-txt
                            text-capitalize">
                            Adicionar Docente
                        </button>
                    </div>
                </div>
            </fieldset>

            <div class="d-flex gap-3 mt-3 mb-5" id="form-btns">
                <input class="d-block
                    m-0 py-2 px-3
                    btn btn-primary rounded-0
                    border border-primary
                    btn-outline-0
                    shadow-none
                    text-primary button-txt
                    text-capitalize" type="button" value="Submeter">
                <input class="d-block
                    m-0 py-2 px-3
                    btn btn-primary rounded-0
                    border border-primary
                    btn-outline-0
                    shadow-none
                    text-primary button-txt
                    text-capitalize" type="button" value="Remover">
                <input class="d-block
                    m-0 py-2 px-3
                    btn btn-primary rounded-0
                    border border-primary
                    btn-outline-0
                    shadow-none
                    text-primary button-txt
                    text-capitalize" type="button" value="Cancelar">
            </div>

        </form>

    </section>

</main>
    
@endsection