'use strict'

// Formulário de Restrições de uma UC
const restricaoForm = document.querySelector('#restricao-form');
restricaoForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
        const formData = new FormData(restricaoForm);

        const res = await fetch(restricaoForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
        });
        if (!res.ok) {
            throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.message}`);
        }

        const data = await res.json();

        if (data.redirect) {
            window.location.href = data.redirect;
        }

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
})