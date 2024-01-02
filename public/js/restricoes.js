'use strict'

// Formulário de Impedimentos
// todo

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