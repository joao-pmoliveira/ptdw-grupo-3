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