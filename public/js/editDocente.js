'use strict';

const deleteUCBtn = document.querySelector('#btn-delete');
deleteUCBtn.addEventListener('click', () => {
    const deleteDocenteForm = document.querySelector('#delete-docente-form')
    deleteDocenteForm.submit();
});
