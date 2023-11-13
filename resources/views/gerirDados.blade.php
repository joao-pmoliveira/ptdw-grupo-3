@extends('layouts.baseContent')

@section('main')
<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', '/inicio']
        ]
    ])
    
    @include('partials._pageTitle', ['title' => 'Gerir Dados'])

    <section class="mt-5">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle='tab' data-bs-target='#manage-ucs'>
                    Gerir Unidades Curriculares
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#manage-teachers'>
                    Gerir Docentes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#import-data'>
                    Importar Dados
                </button>
            </li>
        </ul>
    </section>
    <div class="tab-content pt-3">
        <section id="manage-ucs" class="tab-pane active">
            <div class="d-flex flex-column gap-3">
                <div>
                    <button class="m-0 py-2 px-3
                        btn btn-primary rounded-0
                        border border-primary
                        btn-outline-0
                        shadow-none
                        text-primary button-txt
                        text-capitalize">Adicionar UC</button>
                </div>

                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div>
                        <label for="school-year-semester">Ano Letivo e Semestre:</label>
                        <select name="school_year_semester" id="school-year-semester">
                            <option value="2023_2024_2">2023/24 2ºSemestre</option>
                            <option value="2023_2024_1">2023/24 1ºSemestre</option>
                            <option value="2022_2023_2">2022/23 2ºSemestre</option>
                            <option value="2022_2023_1">2022/23 1ºSemestre</option>
                            <option value="2021_2022_2">2021/22 2ºSemestre</option>
                            <option value="2021_2022_1">2021/22 1ºSemestre</option>
                        </select>
                    </div>
                    <div>
                        <label for="cycle">Ciclo</label>
                        <select name="cycle" id="cycle" >
                            <option value="" selected>Ciclo</option>
                            <option value="Licenciatura">Licenciatura</option>
                            <option value="Mestrado">Mestrado</option>
                            <option value="Doutoramento">Doutoramento</option>
                            <option value="Ctesp">Ctesp</option>
                        </select>
                    </div>
                    <div>
                        <label for="">Código ou Nome de UC</label>
                        <input type="text" name="" id="">
                        <i class="fa-solid fa-search"></i>
                    </div>
                </div>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col-1">Cód.</th>
                                <th scope="col-1">Dep.</th>
                                <th scope="col-5">Nome</th>
                                <th scope="col-3">Docente Responsável</th>
                                <th scope="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"></th>
                                <td>91998</td>
                                <td>dmat</td>
                                <td>Matemática Aplicada às Tecnologias de Informação</td>
                                <td>Luísa Mendes</td>
                                <td><i class="fa-solid fa-pen"></i></td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>88765</td>
                                <td>deca</td>
                                <td>Web Design</td>
                                <td>Rita Gonçalves</td>
                                <td><i class="fa-solid fa-pen"></i></td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>85095</td>
                                <td>deti</td>
                                <td>Inteligência Artificial</td>
                                <td>José Silva</td>
                                <td><i class="fa-solid fa-pen"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="manage-teachers" class="tab-pane">
            <div class="d-flex flex-column gap-3">    
                <div>
                    <button class="btn">Adicionar Docente</button>
                </div>

                <div class="d-flex gap-3 align-items-center">
                    <label for="teacher-identifier">NºMecanográfico ou Nome</label>
                    <input type="text" name="teacher_identifier" id="teacher-identifier" placeholder="11011">
                    <i class="fa-solid fa-search"></i>
                </div>

                <table class="">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nº</th>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <th scope="row"></th>
                            <td>110555</td>
                            <td>José Silva</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>123456</td>
                            <td>Luísa Mendes</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>333555</td>
                            <td>Rita Gonçalves</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="import-data" class="tab-pane">
            <div class="d-flex flex-column gap-3">
                <h2 >Importar dados das Unidades Curriculares</h2>
                <div class="d-flex gap-2 align-items-center">
                    <label for="import-file-input">Selecione um ficheiro</label><br>
                    <input type="file" name="uc-data-file" id="import-file-input">
                </div>
                <div class="d-flex gap-3">
                    <input class="btn" type="button" value="Submeter">
                    <input class="btn" type="button" value="Cancelar">
                </div>
            </div>
        </section>
    </div>
    
</main>

@endsection