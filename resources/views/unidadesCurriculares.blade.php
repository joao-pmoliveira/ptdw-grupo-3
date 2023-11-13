@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Consultar Unidades Curriculares'])

    <section class="container-xl mt-5 p-0 d-flex flex-column gap-4">
        <div class= "d-flex gap-4 align-items-center" >
            <div class="d-flex gap-2 align-items-center px-1">
                <label class="ano_semestre" for="ano_semestre"></label>
                <select class="" name="ano_semestre" id="ano_semestre">
                <option value="" selected>Ano Letivo - Semestre</option> 
                    <option value="2023/24_2º semestre">2023/24 - 2º semestre</option>
                    <option value="2023/24_1º semestre">2023/24 - 1º semestre</option>
                    <option value="2022/23_2º semestre">2022/23 - 2º semestre</option>
                    <option value="2022/23_1º semestre">2022/23 - 1º semestre</option>
                    <option value="2021/22_2º semestre">2021/22 - 2º semestre</option>
                    <option value="2021/22_1º semestre">2021/22 - 1º semestre</option>
                </select>
            </div>

            <div class="d-flex gap-2 align-items-center px-1">
                <label class="" for="ciclo"></label>
                <select class="" name="ciclo" id="ciclo" >
                    <option value="" selected>Ciclo</option> 
                    <option value="Licenciatura">Licenciatura</option>
                    <option value="Mestrado">Mestrado</option>
                    <option value="Doutoramento">Doutoramento</option>
                    <option value="Ctesp">Ctesp</option>
                </select>
            </div>

            <div class="d-flex gap-2 align-items-center px-1">
                <label class="" for="uc"></label>
                <input type="text" name="uc" id="uc">
                <i class="fa-solid fa-search"></i>
            </div>

            <div>
                <label for="">As minhas UC´s</label>
                <input type="checkbox" name="" id="">
            </div>

        </div>
    </section>
    
    <br>
    <br>

    <table class="w-100">
            <thead>
                <tr> 
                    <th scope="col"></th>
                    <th scope="col" >Cód</th>
                    <th scope="col">Dep</th>
                    <th scope="col">Nome</th>
                    <th scope="col" >Docente Responsável</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <td>91998</td>
                    <td>DMAT</td>
                    <td>Cálculo I</td>
                    <td>Luísa Mendes</td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>8765</td>
                    <td>DECA</td>
                    <td>Web design</td>
                    <td>Rita Santos</td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>85095</td>
                    <td>DETI</td>
                    <td>Inteligência Artigicial</td>
                    <td>José Silva</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

</main>
@endsection