'use strict'

const addDocenteForm = document.querySelector('#add-docente-form');
addDocenteForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(addDocenteForm);

    try {
        const res = await fetch(addDocenteForm.action, {
            method: 'POST',
            body: formData,
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