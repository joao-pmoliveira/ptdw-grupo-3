'use strict'

/*sidebar */
const sidebar = document.querySelector('aside')
const menuBtn = document.querySelector('#menu-btn')

menuBtn?.addEventListener('click', () => {
    sidebar?.classList.toggle('show')
})

/*UA Logo Header*/
const uaLogo = document.querySelector('#ua-logo-header-container');
uaLogo?.addEventListener('click', () => {
    window.location.href = '/inicio'
})

/*Tabela de UCs*/
const tabelaUCs = document.querySelector('#table-ucs');
const linhasUCs = tabelaUCs?.querySelectorAll('tr[data-id]');
linhasUCs?.forEach((row) => {
    row.addEventListener('click', () => {
        window.location.href = `/uc/${row.getAttribute('data-id')}`
    })
})
