'use strict'

const addUCForm = document.querySelector('#add-uc-form');
addUCForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(addUCForm);

    try {
        const res = await fetch(addUCForm.action, {
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