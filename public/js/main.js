'use strict'

//sidebar
const sidebar = document.querySelector('aside')
const menuBtn = document.querySelector('#menu-btn')

if (window.location.hostname === 'localhost') {
    baseUrl = 'http://localhost';
} else {
    baseUrl = 'http://estga-dev.ua.pt/~ptdw-2023-gr3';
}

menuBtn?.addEventListener('click', () => {
    sidebar?.classList.toggle('show')
})

//UA Logo Header
const uaLogo = document.querySelector('#ua-logo-header-container');
uaLogo?.addEventListener('click', () => {
    if (window.location.pathname != "/") {
        window.location.href = baseUrl + "/inicio";
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


//Alerts
const secondsPerAlert = 3;
document.querySelectorAll('#alerts > div').forEach(a => {
    setTimeout(() => {
        a.querySelector('.btn-close').click()
    }, secondsPerAlert * 1000);
})