'use strict'

// Formulário de Restrições de uma UC
const restricaoForm = document.querySelector('#restricao-form');
restricaoForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
        const formData = new FormData(restricaoForm);

        const res = await fetch(restricaoForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
        });
        if (!res.ok) {
            throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.message}`);
        }
        const data = await res.json();
        location.reload();

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
})

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