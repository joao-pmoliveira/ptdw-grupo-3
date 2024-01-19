'use strict'

//sidebar
const sidebar = document.querySelector('aside')
const menuBtn = document.querySelector('#menu-btn')

menuBtn?.addEventListener('click', () => {
    sidebar?.classList.toggle('show')
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
const secondsPerAlert = 5;
document.querySelectorAll('#alerts > div').forEach(a => {
    setTimeout(() => {
        a.querySelector('.btn-close').click()
    }, secondsPerAlert * 1000);
})