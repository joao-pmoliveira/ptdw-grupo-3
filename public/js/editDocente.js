'use strict';

const editDocenteForm = document.querySelector('#edit-docente-form');
editDocenteForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(editDocenteForm);

    try {
        const res = await fetch(editDocenteForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
            body: formData,
        });

        if (!res.ok) {
            console.log(res);
            throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.message}`);
        }
        const data = await res.json();

        location.reload();

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
});

const deleteUCBtn = document.querySelector('#btn-delete');
deleteUCBtn.addEventListener('click', async () => {
    const deleteDocenteForm = document.querySelector('#delete-docente-form')
    const formData = new FormData(deleteDocenteForm);
    try {
        const res = await fetch(deleteDocenteForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
        });

        if (!res.ok) {
            console.log(res);
            throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.message}`);
        }
        const data = await res.json();
        console.log(data);

        if (data.redirect) {
            window.location.href = data.redirect;
        }

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
});
