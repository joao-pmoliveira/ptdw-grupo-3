'use strict'

// Formulário de Impedimentos
const impedimentoForm = document.querySelector('#impedimento-form');
impedimentoForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    // todo - check if at least blocks are free

    // todo - if there's at least block selected, justification textarea needs to have text

    try {
        const formData = new FormData(impedimentoForm);

        const res = await fetch(impedimentoForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
        });
        console.log(impedimentoForm.action)
        console.log(res.url)
        alert("  ");
        if (!res.ok) {
            throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.message}`);
        }

        const data = await res.json();
        console.log(data);

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
})

// Tabela com restrições para o próximo semestre
const tableRestricoes = document.querySelector('#table-restricoes-pendentes');
tableRestricoes.querySelectorAll('tbody tr').forEach(row => {
    const ucID = row.getAttribute('data-uc-id');
    const ano = row.getAttribute('data-ano');
    const semestre = row.getAttribute('data-semestre');

    row.addEventListener('click', () => redirectToRestrictionPage(ucID, ano, semestre))
})

function redirectToRestrictionPage(ucID, ano, semestre) {
    window.location.href = `/restricoes/${ucID}/${ano}/${semestre}`
}

// Secção de Históricos

// Tabela Histórico de Impedimentos
const tableHistImpedimentos = document.querySelector('#table-impedimentos-historico');
tableHistImpedimentos.querySelectorAll('tbody tr').forEach(row => {
    const ano = row.getAttribute('data-ano');
    const semestre = row.getAttribute('data-semestre');
    const docenteID = authUser.id;

    row.addEventListener('click', () => {
        window.location.href = `/impedimentos/${docenteID}/${ano}/${semestre}`;
    })
})

//Tabela Histórico de Restrições
const tableHistRestricoes = document.querySelector('#table-restricoes-historico');
tableHistRestricoes.querySelectorAll('tbody tr').forEach(row => {
    const ano = row.getAttribute('data-ano');
    const semestre = row.getAttribute('data-semestre');
    const ucID = row.getAttribute('data-uc-id');
    row.addEventListener('click', () => redirectToRestrictionPage(ucID, ano, semestre))
})