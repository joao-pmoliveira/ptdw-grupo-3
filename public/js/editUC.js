'use strict'

const deleteUCBtn = document.getElementById('btnDelete');
const editUCForm = document.querySelector('#edit-uc-form');

editUCForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(editUCForm);
        console.log(editUCForm.action);
        const res = await fetch(editUCForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },
        });
        console.log(res);
        if (!res.ok) {
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

deleteUCBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(editUCForm);
        
        const res = await fetch(deleteUCRoute, {
            method: 'POST', 
            body: formData, 
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-HTTP-Method-Override': formData.get('_method'),
            },   
        });
        console.log(deleteUCRoute);
        console.log(res.url);
        if (!res.ok) {
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
