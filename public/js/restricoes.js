'use strict'

// Formulário de Impedimentos
const impedimentoForm = document.querySelector('#impedimento-form');
impedimentoForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const unchecked = document.querySelectorAll('#schedule-grid input[type="checkbox"]:not(:checked)');
    const checked = document.querySelectorAll('#schedule-grid input[type="checkbox"]:checked');
    const justification = document.getElementById('justificao-input');

    const minFreeBlocks = unchecked.length >= 2
    const justificationNeeded = checked.length > 0 && justification.value.trim() == ''

    if (!minFreeBlocks || justificationNeeded) {
        if (!minFreeBlocks) document.getElementById('schedule-grid-error').classList.remove('d-none');
        if (justificationNeeded) document.getElementById('justification-error').classList.remove('d-none');
    } else {
        impedimentoForm.submit();
    }
})

// Tabela com restrições para o próximo semestre
const tableRestricoes = document.querySelector('#table-restricoes-pendentes');
tableRestricoes.querySelectorAll('tbody tr').forEach(row => {
    const url = row.getAttribute('data-link');
    if (!url) return;

    row.addEventListener('click', () => window.location.href = url);
})

// Secção de Históricos

// Tabela Histórico de Impedimentos
const tableHistImpedimentos = document.querySelector('#table-impedimentos-historico');
tableHistImpedimentos.querySelectorAll('tbody tr').forEach(row => {
    const url = row.getAttribute('data-link');
    if (!url) return;

    row.addEventListener('click', () => window.location.href = url);
})

//Tabela Histórico de Restrições
const tableHistRestricoes = document.querySelector('#table-restricoes-historico');
tableHistRestricoes.querySelectorAll('tbody tr').forEach(row => {
    const url = row.getAttribute('data-link');
    if (!url) return;

    row.addEventListener('click', () => window.location.href = url);
})

// Preender impedimentos anteriores
const checkboxImpedimento = document.querySelector('#ultimoImpedimento');
checkboxImpedimento.addEventListener("click", () => {
    const daysOfWeek = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
    const dayPeriods = ['manha', 'tarde', 'noite'];

    if (checkboxImpedimento.checked) {
        daysOfWeek.forEach(day => {
            dayPeriods.forEach(period => {
                const checkbox = document.querySelector(`#${day}-${period}-input`);
                checkbox.checked = parseInt(checkbox.getAttribute("data-history"));
            });
        });

        const justificacaoInput = document.querySelector('#justificao-input');
        justificacaoInput.value = justificacaoInput.getAttribute("data-history");
    } else {
        const formImpedimentos = document.querySelector('#impedimento-form');
        formImpedimentos.reset();
    }
});