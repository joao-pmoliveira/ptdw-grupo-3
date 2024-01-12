'use strict'

'use strict';

const editarUCForm = document.querySelector('#edit-uc-form');
editarUCForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(editarUCForm);

    try {
        const res = await fetch(editarUCForm.action, {
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

        if (data.redirect) {
            window.location.href = data.redirect;
        }

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
});

const deleteUCBtn = document.querySelector('#btn-delete');
deleteUCBtn.addEventListener('click', async () => {
    const deleteUCForm = document.querySelector('#delete-uc-form')
    const formData = new FormData(deleteUCForm);
    try {
        const res = await fetch(deleteUCForm.action, {
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

        if (data.redirect) {
            window.location.href = data.redirect;
        }

    } catch (error) {
        console.error(`Error: ${error.message}`);
        console.error(`Error stack: ${error.stack}`);
    }
});


// var selectedDocentes = [];

// document.addEventListener("DOMContentLoaded", function () {
//     var docenteSelects = document.querySelectorAll(".docente-select");

//     docenteSelects.forEach(function (select) {
//         checkDuplicate(select);

//         select.addEventListener("change", function () {
//             checkDuplicate(this);
//         });
//     });
// });

// function checkDuplicate(select) {
//     var selectedOption = select.value;

//     if (selectedOption === "") {
//         // Selecione a opção - não faz nada
//         return;
//     }

//     // Verifica se a opção já está selecionada em algum outro select
//     if (selectedDocentes.includes(selectedOption)) {
//         alert("Docente já selecionado. Escolha outra opção.");
//         select.value = ""; // Volta para a opção "Selecione"
//     } else {
//         // Adiciona o docente selecionado ao array
//         selectedDocentes.push(selectedOption);
//     }
// }