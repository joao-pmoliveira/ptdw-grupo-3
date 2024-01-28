'use strict'

const sendEmailsBtn = document.getElementById('send-emails-btn');
const sendEmailsForm = document.getElementById('send-emails-form');

const toggleAllChecks = document.querySelector('#table input[type="checkbox"]');
const emailChecks = Array.from(document.querySelectorAll('#table tbody input[type="checkbox"]'));
toggleAllChecks.addEventListener('change', () => {
    emailChecks.forEach(check => {
        check.checked = toggleAllChecks.checked;
    })
    toggleSendEmailsBtn();
});

function toggleSendEmailsBtn() {

    const res = emailChecks.reduce((prev, cur) => cur.checked ? true : prev, false);
    sendEmailsBtn.disabled = !res;
}

emailChecks.forEach(c => {
    c.addEventListener('change', () => {
        toggleSendEmailsBtn()
    })
});

sendEmailsForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    emailChecks.filter(c => c.checked)
        .map(c => {
            const node = document.createElement('input');
            node.type = 'number';
            node.hidden = true;
            node.name = 'impedimentos_id[]'
            node.setAttribute('value', c.getAttribute('data-id'))
            return node
        }).forEach(i => {
            sendEmailsForm.appendChild(i);
        })

    sendEmailsForm.submit();

})