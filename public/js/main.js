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

//Tabela de Editar Docentes
const tabelaEditarDocentes = document.querySelector('#table-edit-teachers')
const linhasEditarDocentes = tabelaEditarDocentes?.querySelectorAll('tr[data-id]')
linhasEditarDocentes?.forEach(row => {
    row.addEventListener('click', () => {
        window.location.href = window.location.href.replace("/gerir-dados", `/docentes/${row.getAttribute('data-id')}/editar`)
    })
})

const filterDocenteNome = document.querySelector('#teacher-identifier');
filterDocenteNome.addEventListener('input', () => {
    const value = filterDocenteNome.value.toLowerCase();
    const rows = Array.from(linhasEditarDocentes);
    rows.forEach(row => {
        const rowNameText = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
        const rowNumberText = row.querySelector('td:nth-child(2)').innerText.toLowerCase();

        if (rowNameText.includes(value) || rowNumberText.includes(value)) {
            row.style.display = 'table-row'
        } else {
            row.style.display = 'none'
        }
    })
});

//Logout
const logoutBtn = document.getElementById('logout-btn');
logoutBtn?.addEventListener('click', () => {
    alert('logout sent')
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/logout', {
        method: 'POST',
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            _token: csrfToken
        })
    })
})