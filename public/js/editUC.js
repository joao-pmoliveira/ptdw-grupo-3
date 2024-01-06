'use strict'

const deleteUCBtn = document.getElementById('btnDelete');
const editUCForm = document.querySelector('#edit-uc-form');

editUCForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(editUCForm);
    try {
        const res = await fetch(editUCForm.action, {
            method: 'PUT',
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
});

deleteUCBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    try {
        const res = await fetch(deleteUCRoute, {
            method: 'DELETE',     
        });
        console.log(res);
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
});
