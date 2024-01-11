'use strict'

const deleteUCBtn = document.querySelector('#btn-delete');
const editUCForm = document.querySelector('#edit-uc-form');

editUCForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(editUCForm);

        const res = await fetch(editUCForm.action, {
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
});

deleteUCBtn.addEventListener('click', async (e) => {
    const confirmation = confirm('Tem a certeza que deseja eliminar este docente?');

    if (confirmation) {
        e.preventDefault();
        try {
            const formData = new FormData(editUCForm);

            const res = await fetch(editUCForm.action, {
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
            console.log(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }

        } catch (error) {
            console.error(`Error: ${error.message}`);
            console.error(`Error stack: ${error.stack}`);
        }
    }
});
var selectedDocentes = [];

document.addEventListener("DOMContentLoaded", function () {
    var docenteSelects = document.querySelectorAll(".docente-select");

    docenteSelects.forEach(function (select) {
        checkDuplicate(select);
        
        select.addEventListener("change", function () {
            checkDuplicate(this);
        });
    });
});

function checkDuplicate(select) {
    var selectedOption = select.value;

    if (selectedOption === "") {
        // Selecione a opção - não faz nada
        return;
    }

    // Verifica se a opção já está selecionada em algum outro select
    if (selectedDocentes.includes(selectedOption)) {
        alert("Docente já selecionado. Escolha outra opção.");
        select.value = ""; // Volta para a opção "Selecione"
    } else {
        // Adiciona o docente selecionado ao array
        selectedDocentes.push(selectedOption);
    }
}