'use strict'

//#region Tabela de Unidades Curriculares
const tableEditUCs = document.querySelector('#table-edit-ucs');

tableEditUCs.querySelectorAll('tbody tr:not(:is([id="edit-ucs-no-match-row"]))').forEach(row => {
    row.addEventListener('click', () => {
        window.location.href = row.getAttribute('data-link');
    })
});

//Filtros
const periodoSelect = document.querySelector('#school-year-semester');
periodoSelect.addEventListener('change', async () => {
    const [anoInicial, anoFinal, semestre] = periodoSelect.value.split('_');

    const baseURL = `${periodoSelect.getAttribute('data-link')}/por-ano-semestre`;
    const res = await fetch(`${baseURL}/${anoInicial}/${semestre}`);
    const data = await res.json();

    const tableBody = tableEditUCs.querySelector('tbody');
    tableBody.querySelectorAll('tr:not([id="edit-ucs-no-match-row"])').forEach(row => row.remove());

    data.forEach(uc => {
        const id = uc['id'];
        const nome = uc['nome'];
        const codigo = uc['codigo'];
        const link = uc['link']
        const nomeDocenteResponsavel = uc['docente_responsavel']['user']['nome'];

        // todo @joao: adicionar atributos que faltam
        const row = document.createElement('tr');
        row.classList.add('border', 'border-light');
        row.setAttribute('data-id', id);
        row.setAttribute('data-curso-id', uc['cursos'].map(curso => curso['id']).toString());
        row.setAttribute('data-link', link);

        const th = document.createElement('th');
        th.setAttribute('scope', 'row');
        const codigoCel = document.createElement('td');
        codigoCel.textContent = codigo;
        const nomeCel = document.createElement('td');
        nomeCel.textContent = nome;
        const docenteResCel = document.createElement('td');
        docenteResCel.textContent = nomeDocenteResponsavel;
        const iconCel = document.createElement('td');
        const icon = document.createElement('i');
        icon.classList.add('fa-solid', 'fa-pen');
        iconCel.appendChild(icon);

        row.appendChild(th);
        row.appendChild(codigoCel);
        row.appendChild(nomeCel);
        row.appendChild(docenteResCel);
        row.appendChild(iconCel);

        tableBody.appendChild(row);

        row.addEventListener('click', () => window.location.href = `${row.getAttribute('data-link')}/editar`);
    })

    filterTableEditUCs();
});

const searchUCTextInput = document.querySelector('#input-filter-ucs-nome');
searchUCTextInput.addEventListener('input', filterTableEditUCs);
const searchUCBtn = document.querySelector('#manage-ucs .paco-searchbox > div');
searchUCBtn.addEventListener('click', filterTableEditUCs);
const cursoSelect = document.querySelector('#school-year-school_course');
cursoSelect.addEventListener('change', filterTableEditUCs);
const semDocenteRespCheck = document.querySelector('#ucs-sem-responsavel-check');
semDocenteRespCheck.addEventListener('change', filterTableEditUCs);

function filterTableEditUCs() {
    const hiddenRow = document.querySelector('#edit-ucs-no-match-row');
    let match = false;
    Array.from(tableEditUCs.querySelectorAll('tbody tr:not(:is([id="edit-ucs-no-match-row"]))')).forEach(row => {
        const nome = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const codigo = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        const searchInput = searchUCTextInput.value.toLowerCase();
        const cursoID = cursoSelect.value;
        const docenteResp = row.querySelector('td:nth-child(4)').innerText;


        const filterByNameCode = nome.includes(searchInput) || codigo.includes(searchInput);
        const filterByCurso = cursoID === '' || row.getAttribute('data-curso-id').split(',').indexOf(cursoID) != -1;
        const filterByUCSemResp = !semDocenteRespCheck.checked || (semDocenteRespCheck.checked && docenteResp === '---');

        if (filterByNameCode && filterByCurso && filterByUCSemResp) {
            row.style.display = 'table-row'
            match = true
        }
        else {
            row.style.display = 'none'
        }

    });

    hiddenRow.style.display = match ? 'none' : 'table-row';
}
//#endregion


//#region Tabela de Docentes

const tableEditDocentes = document.querySelector('#table-edit-teachers');
tableEditDocentes.querySelectorAll('tbody tr:not(:is([id="edit-teachers-no-match-row"]))').forEach(row => {
    //const docenteID = row.getAttribute('data-id');
    row.addEventListener('click', () => window.location.href = `${row.getAttribute('data-link')}`);
})

const searchDocenteTextInput = document.querySelector('#teacher-identifier');
searchDocenteTextInput.addEventListener('input', filterTableEditDocentes);
const searchDocenteBtn = document.querySelector('#manage-teachers .paco-searchbox div');
searchDocenteBtn.addEventListener('input', filterTableEditDocentes);

function filterTableEditDocentes() {
    const hiddenRow = document.querySelector('#edit-teachers-no-match-row');
    let match = false;
    Array.from(tableEditDocentes.querySelectorAll('tbody tr:not(:is([id="edit-teachers-no-match-row"]))')).forEach(row => {
        const nome = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const codigo = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        const searchInput = searchDocenteTextInput.value.toLowerCase();

        if (nome.includes(searchInput) || codigo.includes(searchInput)) {
            row.style.display = 'table-row'
            match = true
        } else {
            row.style.display = 'none'
        }
    })

    hiddenRow.style.display = match ? 'none' : 'table-row';
}
//#endregion


document.addEventListener('DOMContentLoaded', () => {
    filterTableEditUCs();
    filterTableEditDocentes();
})