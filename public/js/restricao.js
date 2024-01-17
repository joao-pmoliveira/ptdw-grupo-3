'use strict'
// Preender restricao anterior
const checkboxRestricao = document.querySelector('#ultimaRestricao');
checkboxRestricao.addEventListener("click", () => {
    if (checkboxRestricao.checked) {

        const checkboxAulaLaboratorio = document.querySelector("#aula-laboratorio-input");
        checkboxAulaLaboratorio.checked = parseInt(checkboxAulaLaboratorio.getAttribute("data-history"));

        const checkboxExameFinal = document.querySelector("#exame-final-laboratorio");
        checkboxExameFinal.checked = parseInt(checkboxExameFinal.getAttribute("data-history"));

        const checkboxExameRecurso = document.querySelector("#exame-recurso-laboratorio");
        checkboxExameRecurso.checked = parseInt(checkboxExameRecurso.getAttribute("data-history"));

        const observacoesInput = document.querySelector('#observacoes-input');
        observacoesInput.value = observacoesInput.getAttribute("data-history");

        const softwareInput = document.querySelector('#software-necessario-input');
        softwareInput.value = softwareInput.getAttribute("data-history");


    } else {
        restricaoForm.reset();
    }
});