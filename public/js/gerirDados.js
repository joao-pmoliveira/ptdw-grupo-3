'use strict'

//#region Tabela de Unidades Curriculares
const tableEditUCs = document.querySelector('#table-edit-ucs');
tableEditUCs.querySelectorAll('tbody tr').forEach(row => {
    const ucID = row.getAttribute('data-id');
    row.addEventListener('click', () => {
        window.location.href = `/ucs/${ucID}/editar`;
    })
});

//Filtros
const periodoSelect = document.querySelector('#school-year-semester');
periodoSelect.addEventListener('change', async () => {
    const [anoInicial, anoFinal, semestre] = periodoSelect.value.split('_');

    const baseURL = '/api/unidades-curriculares/por-ano-semestre';
    const res = await fetch(`${baseURL}/${anoInicial}/${semestre}`);
    const data = await res.json();

    const tableBody = tableEditUCs.querySelector('tbody');
    tableBody.innerHTML = '';

    data.forEach(uc => {
        const id = uc['id'];
        const nome = uc['nome'];
        const codigo = uc['codigo'];
        const nomeDocenteResponsavel = uc['docente_responsavel']['user']['nome'];

        const row = document.createElement('tr');
        row.setAttribute('data-id', id);
        row.setAttribute('data-curso-id', uc['cursos'].map(curso => curso['id']).toString());

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

        row.addEventListener('click', () => window.location.href = `/ucs/${id}/editar`);
    })

    filterTableEditUCs();
});

const searchUCTextInput = document.querySelector('#input-filter-ucs-nome');
searchUCTextInput.addEventListener('input', filterTableEditUCs);
const searchUCBtn = document.querySelector('#manage-ucs .paco-searchbox > div');
searchUCBtn.addEventListener('click', filterTableEditUCs);
const cursoSelect = document.querySelector('#school-year-school_course');
cursoSelect.addEventListener('change', filterTableEditUCs);

function filterTableEditUCs() {
    Array.from(tableEditUCs.querySelectorAll('tbody tr')).forEach(row => {
        const nome = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const codigo = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        const searchInput = searchUCTextInput.value.toLowerCase();
        const cursoID = cursoSelect.value;

        const filterByNameCode = nome.includes(searchInput) || codigo.includes(searchInput);
        const filterByCurso = cursoID === '' || row.getAttribute('data-curso-id').split(',').indexOf(cursoID) != -1;

        if (filterByNameCode)
            if (filterByCurso)
                row.style.display = 'table-row'
            else
                row.style.display = 'none'
        else
            row.style.display = 'none'

    });
}

//#endregion


//#region Tabela de Docentes

const tableEditDocentes = document.querySelector('#table-edit-teachers');
tableEditDocentes.querySelectorAll('tbody tr').forEach(row => {
    const docenteID = row.getAttribute('data-id');
    row.addEventListener('click', () => window.location.href = `/docentes/${docenteID}/editar`);
})

const searchDocenteTextInput = document.querySelector('#teacher-identifier');
searchDocenteTextInput.addEventListener('input', filterTableEditDocentes);
const searchDocenteBtn = document.querySelector('#manage-teachers .paco-searchbox div');
searchDocenteBtn.addEventListener('input', filterTableEditDocentes);

function filterTableEditDocentes() {
    Array.from(tableEditDocentes.querySelectorAll('tbody tr')).forEach(row => {
        const nome = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const codigo = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        const searchInput = searchDocenteTextInput.value.toLowerCase();

        if (nome.includes(searchInput) || codigo.includes(searchInput)) {
            row.style.display = 'table-row'
        } else {
            row.style.display = 'none'
        }
    })
}
//#endregion

//#region Upload Ficheiro do Serviço-Docente

const submitForm = document.querySelector('#import-data form')
submitForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(submitForm);

    try {
        const res = await fetch(submitForm.action, {
            method: 'POST',
            body: formData
        })
        const data = await res.json();

        console.log(data);
    } catch (error) {
        console.log(error);
    }
})

//#endregion