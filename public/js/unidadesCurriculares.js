'use strict'

const tableUCs = document.querySelector('#table-ucs');
const initRows = tableUCs.querySelectorAll('#table-ucs tbody tr');
initRows.forEach(row => {
    row.addEventListener('click', () => redirectToUCPage(row));
})

function redirectToUCPage(ucRow) {
    window.location.href = `/ucs/${ucRow.getAttribute('data-id')}`;
}

const periodoSelect = document.querySelector('select#ano_semestre');
periodoSelect?.addEventListener('change', async () => {
    const selected = periodoSelect.value;

    const [anoInicial, anoFinal, semestre] = selected.split('_');
    const baseURL = '/api/unidades-curriculares/por-ano-semestre';

    const res = await fetch(`${baseURL}/${anoInicial}/${semestre}`);
    const data = await res.json();

    const tableBody = document.querySelector('#table-ucs tbody');
    tableBody.innerHTML = '';

    data.forEach(uc => {
        const id = uc['id'];
        const nome = uc['nome'];
        const codigo = uc['codigo'];
        const nomeDocenteResponsavel = uc['docente_responsavel']['user']['nome'];

        const row = document.createElement('tr');
        row.setAttribute('data-id', id);

        const userUC = Array.from(uc['docentes']).map(d => d['id']).filter(id => id == authUser.id);
        row.setAttribute('data-my-uc', userUC.length !== 0 ? 'Y' : 'N');

        const th = document.createElement('th');
        th.setAttribute('scope', 'row');

        const codigoCel = document.createElement('td');
        codigoCel.textContent = codigo;
        const nomeCel = document.createElement('td');
        nomeCel.textContent = nome;
        const docenteResCel = document.createElement('td');
        docenteResCel.textContent = nomeDocenteResponsavel;

        row.appendChild(th);
        row.appendChild(codigoCel);
        row.appendChild(nomeCel);
        row.appendChild(docenteResCel);

        tableBody.appendChild(row);

        row.addEventListener('click', () => redirectToUCPage(row));
    })

    filterTableUcs();
});

const searchUCTextInput = document.querySelector('input#uc');
searchUCTextInput.addEventListener('input', filterTableUcs);
const searchUCBtn = document.querySelector('#filter-ucs-by-name-btn');
searchUCBtn.addEventListener('click', filterTableUcs);
const userUCsFilterToggle = document.querySelector('#my-classes-check');
userUCsFilterToggle.addEventListener('click', filterTableUcs);

function filterTableUcs() {
    const rows = Array.from(document.querySelectorAll('#table-ucs tbody tr'));
    rows.forEach(row => {
        const ucName = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const ucCode = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        const searchInput = searchUCTextInput.value.toLowerCase();

        const checked = userUCsFilterToggle.checked;
        const userUC = row.getAttribute('data-my-uc') === 'Y';

        const filterByNameCode = ucName.includes(searchInput) || ucCode.includes(searchInput)
        const filterByUserUCs = !checked || row.getAttribute('data-my-uc') === 'Y';

        if (filterByNameCode && filterByUserUCs) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}