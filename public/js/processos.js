'use strict'

const formulariosForm = document.querySelector('#gerar-formularios-form');

formulariosForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(formulariosForm);

    const res = await fetch(formulariosForm.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
        },
        body: formData
    })

    const data = await res.json();

    console.log(data.message);

})