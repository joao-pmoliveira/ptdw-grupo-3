<fieldset class="title-separator px-3 d-flex flex-column gap-2 mb-4">
    <legend class="class-fieldset-heading py-1">{{$class['id']}} {{$class['name']}}</legend>
    <fieldset class="">
        <legend>Tipo de Sala</legend>
        <br>
        <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
            <div class="paco-checkbox">
                <label class="form-check-label" for="obligatory-labs">Sala Comum &nbsp;&nbsp;</label>
                <div class="form-check form-switch">
                    <input class="form-check-input --primary-backgroud-color" name="obligatory_labs"
                        id="obligatory-labs" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="obligatory-labs">&nbsp;&nbsp;Laboratório de Informática</label>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="">
        <legend>Software necessário</legend>
        <p>Identifique nome, fabricante, versão, e sistema operativo</p>
        <label for="needed-sof"></label>
        <textarea class="mx-3" name="needed_software" id="needed-soft" cols="100" rows="7"></textarea>
    </fieldset>
    <fieldset class=" px3">
        <legend>Tipo de sala para avaliações</legend>
        <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
            <div class="paco-checkbox">
                <label class="form-check-label" for="lav-eval">Sala Comum &nbsp;&nbsp;</label>
                <div class="form-check form-switch">
                    <input class="form-check-input --primary-backgroud-color" name="lav-eval" id="lav-eval"
                        type="checkbox" role="switch" id="lav-eval">
                    <label class="form-check-label" for="lav-eval">&nbsp;&nbsp;Laboratório de Informática</label>
                </div>
            </div>
        </div>
    </fieldset>
</fieldset>