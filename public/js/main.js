'use strict'

//sidebar
const sidebar = document.querySelector('aside')
const menuBtn = document.querySelector('#menu-btn')

menuBtn?.addEventListener('click', () => {
    sidebar?.classList.toggle('show')
})

//UA Logo Header
const uaLogo = document.querySelector('#ua-logo-header-container');
uaLogo?.addEventListener('click', () => {
    if (window.location.pathname != "/") {
        window.location.href = "/inicio";
    }
})

//Tabela de UCs
function redirectToUCPage(row) {
    window.location.href = `/ucs/${row.getAttribute("data-id")}`;
}

const tabelaUCs = document.querySelector('#table-ucs');
const linhasUCs = tabelaUCs?.querySelectorAll('tr[data-id]');
linhasUCs?.forEach((row) => {
    row.addEventListener('click', () => redirectToUCPage(row))
})

//Filtros da tabela de UCs
const periodoSelect = document.querySelector('select#ano_semestre');
periodoSelect?.addEventListener('change', async () => {
    const selected = periodoSelect.value;

    const [startYear, endYear, semestre] = selected.split("_");

    const baseURL = "/api/unidades-curriculares/por-ano-semestre";

    const response = await fetch(`${baseURL}/${startYear}/${semestre}`);
    const data = await response.json();
    const tableBody = document.querySelector('#table-ucs > tbody');
    tableBody.innerHTML = "";

    data.forEach(row => {
        const idUC = row["id"]
        const nomeUC = row["nome"];
        const codigoUC = row["codigo"];
        const nomeDocenteResponsavel = row["docente_responsavel"]["nome"];

        const tRow = document.createElement("tr");
        tRow.setAttribute("data-id", idUC);

        const tHead = document.createElement("th");
        tHead.setAttribute("scope", "row");

        const tdCodigo = document.createElement("td");
        tdCodigo.textContent = codigoUC;

        const tdNome = document.createElement("td");
        tdNome.textContent = nomeUC;

        const tdDocenteResp = document.createElement("td");
        tdDocenteResp.textContent = nomeDocenteResponsavel;

        tRow.appendChild(tHead);
        tRow.appendChild(tdCodigo);
        tRow.appendChild(tdNome);
        tRow.appendChild(tdDocenteResp);

        tableBody.appendChild(tRow);

        addEventListener('click', () => redirectToUCPage(tRow));
    })

})

const filterNomeUC = document.querySelector('input#uc');
filterNomeUC?.addEventListener('input', () => filterTableRowsByName(filterNomeUC.value))
const filterNomeBtn = document.querySelector('#filter-ucs-by-name-btn');
filterNomeBtn?.addEventListener('click', () => filterTableRowsByName(filterNomeUC.value))

function filterTableRowsByName(search) {
    const searchText = search.toLowerCase();
    const rows = Array.from(document.querySelectorAll("#table-ucs tbody >  tr"));
    rows.forEach(row => {
        const rowText = row.querySelector("td:nth-child(3)").innerText.toLowerCase();
        if (rowText.includes(searchText)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    })
}


//Tabela de Formulários Atuais
const tabelaFormsAtuais = document.querySelector('#table-forms-pendentes');
const linhasFormularios = tabelaFormsAtuais?.querySelectorAll('tbody tr')
linhasFormularios?.forEach(row => {
    row.addEventListener('click', () => {
        const startYear = row.getAttribute('data-start-year')
        const semester = row.getAttribute('data-semester')
        const ucID = row.getAttribute('data-uc-id');
        window.location.href = `/restricoes/${ucID}/${startYear}/${semester}`;
    })
})

//Tabela de Histórico de Impedimentos
const tabelaHistoricoImped = document.querySelector('#table-impedimentos-historico');
const linhasHistImped = tabelaHistoricoImped?.querySelectorAll('tr');
linhasHistImped?.forEach(row => {
    row.addEventListener('click', () => {
        const startYear = row.getAttribute('data-start-year')
        const semester = row.getAttribute('data-semester')
        const docenteID = 20;
        window.location.href = `/impedimentos/${docenteID}/${startYear}/${semester}`;
    })
})

//Tabela de Histórico de Impedimentos
const tabelaHistoricoRestric = document.querySelector('#table-restricoes-historico');
const linhasHistRestrict = tabelaHistoricoRestric?.querySelectorAll('tr');
linhasHistRestrict?.forEach(row => {
    row.addEventListener('click', () => {
        const startYear = row.getAttribute('data-start-year')
        const semester = row.getAttribute('data-semester')
        const ucID = row.getAttribute('data-uc-id');
        window.location.href = `/restricoes/${ucID}/${startYear}/${semester}`;
    })
})

//Tabela de Gerir Unidades Curriculares (Gerir Dados)
const tabelaEditarUCs = document.querySelector('#table-edit-ucs')
const linhasEditarUCs = tabelaEditarUCs?.querySelectorAll('tr[data-id]')
linhasEditarUCs?.forEach(row => {
    row.addEventListener('click', () => {
        window.location.href = window.location.href.replace("/gerir-dados", `/ucs/${row.getAttribute('data-id')}/editar`)
    })
})

//Filtros Tabela de Gerir Unidades Curriculares
const anoSemestreUCFilter = document.querySelector('#school-year-semester');
anoSemestreUCFilter?.addEventListener('change', async () => {
    const [startYear, endYear, semester] = anoSemestreUCFilter.value.split("_");

    const baseURL = '/api/unidades-curriculares/por-ano-semestre';
    const response = await fetch(`${baseURL}/${startYear}/${semester}'`);
    const data = await response.json();

    const tableBody = document.querySelector('#table-edit-ucs > tbody')
    tableBody.innerHTML = "";

    data.forEach(row => {
        const idUC = row["id"]
        const nomeUC = row["nome"];
        const codigoUC = row["codigo"];
        const nomeDocenteResponsavel = row["docente_responsavel"]["nome"];

        const tRow = document.createElement("tr");
        tRow.setAttribute("data-id", idUC);
        tRow.setAttribute("data-curso-id", row['cursos'].map(curso => curso['id']).toString())

        const tHead = document.createElement("th");
        tHead.setAttribute("scope", "row");

        const tdCodigo = document.createElement("td");
        tdCodigo.textContent = codigoUC;

        const tdNome = document.createElement("td");
        tdNome.textContent = nomeUC;

        const tdDocenteResp = document.createElement("td");
        tdDocenteResp.textContent = nomeDocenteResponsavel;

        const tdEditIcon = document.createElement("td");
        const icon = document.createElement("i");
        icon.classList.add("fa-solid");
        icon.classList.add("fa-pen");
        tdEditIcon.appendChild(icon);

        tRow.appendChild(tHead);
        tRow.appendChild(tdCodigo);
        tRow.appendChild(tdNome);
        tRow.appendChild(tdDocenteResp);
        tRow.appendChild(tdEditIcon);

        tableBody.appendChild(tRow);

        tRow.addEventListener('click', () => {
            window.location.href = `/ucs/${tRow.getAttribute("data-id")}/editar`
        })
    })

    filterByDegree();

});

const degreeUCFilter = document.querySelector('#school-year-school_course');
degreeUCFilter?.addEventListener('change', filterByDegree);

function filterByDegree() {
    const degreeID = degreeUCFilter.value;

    const rows = Array.from(document.querySelectorAll('#table-edit-ucs tbody tr'));

    rows.forEach(row => {
        const rowDegrees = row.getAttribute('data-curso-id').split(",");
        if (degreeID == "" || rowDegrees.indexOf(degreeID) != -1) {
            row.style.display = 'table-row'
        } else {
            row.style.display = 'none'
        }
    })
}

const filterUCNome = document.querySelector('#input-filter-ucs-nome');
filterUCNome?.addEventListener('input', () => {
    const value = filterUCNome.value;
    const searchText = value.toLowerCase();
    const rows = Array.from(document.querySelectorAll("#table-edit-ucs tbody tr"));
    rows.forEach(row => {
        const rowText = row.querySelector("td:nth-child(3)").innerText.toLowerCase();
        if (rowText.includes(searchText)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    })
});

//Tabela de Editar Docentes
const tabelaEditarDocentes = document.querySelector('#table-edit-teachers')
const linhasEditarDocentes = tabelaEditarDocentes?.querySelectorAll('tr[data-id]')
linhasEditarDocentes?.forEach(row => {
    row.addEventListener('click', () => {
        window.location.href = window.location.href.replace("/gerir-dados", `/docentes/${row.getAttribute('data-id')}/editar`)
    })

})