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
    window.location.href = '/inicio'
})

//Tabela de UCs
const tabelaUCs = document.querySelector('#table-ucs');
const linhasUCs = tabelaUCs?.querySelectorAll('tr[data-id]');
linhasUCs?.forEach((row) => {
    row.addEventListener('click', () => {
        window.location.href = `/uc/${row.getAttribute('data-id')}`
    })
})

//Tabela de Formulários Atuais
const tabelaFormsAtuais = document.querySelector('#table-forms-pendentes');
const linhasFormularios = tabelaFormsAtuais?.querySelectorAll('tr[data-type="impedimento"],tr[data-type="restrição"]')
linhasFormularios?.forEach(row => {
    row.addEventListener('click', () => {
        const formType = row.getAttribute('data-type')
        const startYear = row.getAttribute('data-start-year')
        const endYear = row.getAttribute('data-end-year')
        const semester = row.getAttribute('data-semester')
        window.location.href = `/${formType}/${startYear}_${endYear}/${semester}/110111`
    })
})

//Tabela de Histórico de Formulários
const tabelaHistoricoForms = document.querySelector('#table-historico-formularios')
const linhaHistoricos = tabelaHistoricoForms?.querySelectorAll('tr[data-type="impedimento"],tr[data-type="restrição"]')
linhaHistoricos?.forEach(row => {
    row.addEventListener('click', () => {
        const formType = row.getAttribute('data-type')
        const startYear = row.getAttribute('data-start-year')
        const endYear = row.getAttribute('data-end-year')
        const semester = row.getAttribute('data-semester')
        window.location.href = `/${formType}/${startYear}_${endYear}/${semester}/110111`
    })
})