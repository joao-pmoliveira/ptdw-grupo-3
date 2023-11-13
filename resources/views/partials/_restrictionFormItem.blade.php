<fieldset class="title-separator px-3 d-flex flex-column gap-2 mb-4">
    <legend class="class-fieldset-heading py-1" >{{$class['id']}} {{$class['name']}}</legend>
    <fieldset class="">
        <legend>Utilização de Laboratórios</legend>
        <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
            <div>
                <label for="">Obrigatório</label>
                <input type="checkbox" name="" id="">
            </div>
            <div >
                <label for="">Preferencial</label>
                <input type="checkbox" name="" id="">
            </div>
        </div>
        <div class="lab-select-grid px-3">
            <label class="" for="lab-one">Laboratório</label>
            <select name="lab_one" id="lab-one" >
                <option value="" selected>--selecione--</option>
                <option value="5.1.10">5.1.10</option>
                <option value="5.1.11">5.1.11</option>
                <option value="5.1.12">5.1.12</option>
                <option value="5.1.13">5.1.13</option>
                <option value="5.1.14">5.1.14</option>
                <option value="5.1.15">5.1.15</option>
            </select>
            <label for="lab-two">Laboratório</label>
            <select name="lab_two" id="lab-two" >
                <option value="" selected>--selecione--</option>
                <option value="5.1.10">5.1.10</option>
                <option value="5.1.11">5.1.11</option>
                <option value="5.1.12">5.1.12</option>
                <option value="5.1.13">5.1.13</option>
                <option value="5.1.14">5.1.14</option>
                <option value="5.1.15">5.1.15</option>
            </select>
            <label for="lab-three">Laboratório</label>
            <select name="lab_three" id="lab-three" >
                <option value="" selected>--selecione--</option>
                <option value="5.1.10">5.1.10</option>
                <option value="5.1.11">5.1.11</option>
                <option value="5.1.12">5.1.12</option>
                <option value="5.1.13">5.1.13</option>
                <option value="5.1.14">5.1.14</option>
                <option value="5.1.15">5.1.15</option>
            </select>
            <label for="lab-four">Laboratório</label>
            <select name="lab_four" id="lab-four" >
                <option value="" disabled selected>--selecione--</option>
                <option value="5.1.10">5.1.10</option>
                <option value="5.1.11">5.1.11</option>
                <option value="5.1.12">5.1.12</option>
                <option value="5.1.13">5.1.13</option>
                <option value="5.1.14">5.1.14</option>
                <option value="5.1.15">5.1.15</option>
            </select>
        </div>
    </fieldset>
    <fieldset class="">
        <legend>Software necessário</legend>
        <p>Identifique nome, fabricante, versão, e sistema operativo</p>
        <label for="needed-sof"></label>
        <textarea class="mx-3" name="needed_software" id="needed-soft" cols="10"></textarea>
    </fieldset>
    <fieldset class=" px3">
        <legend>Tipo de sala para avaliações</legend>
        <div class="px-3">
            <label class="" for="lab-eval">Laboratório</label>
            <select name="lab_eval" id="lab-eval" >
                <option value="" selected>--selecione--</option>
                <option value="5.1.10">5.1.10</option>
                <option value="5.1.11">5.1.11</option>
                <option value="5.1.12">5.1.12</option>
                <option value="5.1.13">5.1.13</option>
                <option value="5.1.14">5.1.14</option>
                <option value="5.1.15">5.1.15</option>
            </select>
        </div>
    </fieldset>
</fieldset>