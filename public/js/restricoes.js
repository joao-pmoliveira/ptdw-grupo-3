'use strict'

// Formulário de Impedimentos
const impedimentoForm = document.querySelector('#impedimento-form');

if (window.location.hostname === 'localhost') {
    baseUrl = 'http://localhost';
} else {
    baseUrl = 'http://estga-dev.ua.pt/~ptdw-2023-gr3';
}

impedimentoForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const unchecked = document.querySelectorAll('#schedule-grid input[type="checkbox"]:not(:checked)');
    if (unchecked.length < 2) {
        alert('Pelo menos 2 blocos livres!');
        return;
    }

    const checked = document.querySelectorAll('#schedule-grid input[type="checkbox"]:checked');
    const justification = document.getElementById('justificao-input');
    if (checked.length > 0 && justification.value.trim() == '') {
        alert('Justificação é necessária!');
        return;
    }

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

// Tabela com restrições para o próximo semestre
const tableRestricoes = document.querySelector('#table-restricoes-pendentes');
tableRestricoes.querySelectorAll('tbody tr').forEach(row => {
    const ucID = row.getAttribute('data-uc-id');
    const ano = row.getAttribute('data-ano');
    const semestre = row.getAttribute('data-semestre');

    row.addEventListener('click', () => redirectToRestrictionPage(ucID, ano, semestre))
})

function redirectToRestrictionPage(ucID, ano, semestre) {
    window.location.href = baseUrl +`/restricoes/${ucID}/${ano}/${semestre}`
}

// Secção de Históricos

// Tabela Histórico de Impedimentos
const tableHistImpedimentos = document.querySelector('#table-impedimentos-historico');
tableHistImpedimentos.querySelectorAll('tbody tr').forEach(row => {
    const ano = row.getAttribute('data-ano');
    const semestre = row.getAttribute('data-semestre');
    const docenteID = authUser.id;

    row.addEventListener('click', () => {
        window.location.href = baseUrl +`/impedimentos/${docenteID}/${ano}/${semestre}`;
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