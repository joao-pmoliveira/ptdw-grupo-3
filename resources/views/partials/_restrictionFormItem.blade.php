<div class="title-separator d-flex flex-column gap-3 py-4">
    <fieldset class="">
        <legend>Tipo de Sala</legend>
        <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
            <div class="paco-checkbox">
                <label class="form-check-label" for="obligatory-labs">Sala Comum</label>
                <div class="form-check form-switch d-flex align-items-center mx-2 gap-2">
                    <input class="form-check-input" name="obligatory_labs" id="obligatory-labs" type="checkbox" {{
                        ($uc->laboratorio) ? "checked" : "" }} role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="obligatory-labs">Laboratório de Informática</label>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="">
        <legend>Software necessário</legend>
        <p>Identifique nome, fabricante, versão, e sistema operativo</p>
        <label for="needed-soft"></label>
        <textarea class="mx-3 px-2 py-1" name="needed_software" id="needed-soft" cols="100"
            rows="7">{{$uc->software}}</textarea>
    </fieldset>

    <fieldset class=" px3">
        <legend>Tipo de sala para avaliações</legend>
        <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
            <div class="paco-checkbox">
                <label class="form-check-label" for="evaluation-labs">Sala Comum</label>
                <div class="form-check form-switch d-flex align-items-center mx-2 gap-2">
                    <input class="form-check-input" name="evaluation_labs" id="evaluation-labs" type="checkbox" {{
                        ($uc->sala_avaliacao) ? "checked" : "" }} role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="evaluation-labs">Laboratório de Informática</label>
                </div>
            </div>
        </div>
    </fieldset> 
</div>