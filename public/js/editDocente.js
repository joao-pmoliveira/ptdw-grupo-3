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

const deleteDocenteBtn = document.querySelector('#btn-delete');
deleteDocenteBtn.addEventListener('click', async () => {
    const confirmation = confirm('Tem a certeza que deseja eliminar este docente?');

    if (confirmation) {
        try {
            const res = await fetch(editDocenteForm.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("input[type='hidden']").value
                },
            });

            if (!res.ok) {
                throw new Error(`HTTP Error! Status: ${res.status}, Message: ${res.statusText}`);
            }

            const data = await res.json();

            if (data.redirect) {
                window.location.href = data.redirect;
            }

        } catch (error) {
            console.error(`Error: ${error.message}`);
        }
    }
});
