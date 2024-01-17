'use strict';

//* Formulário 'Apagar Unidade Curricular'
document.querySelector('#btn-delete').addEventListener('click', () => {
    document.querySelector('#delete-uc-form').submit();
})

//Impedir que um docente seja associado mais do que um vez à mesma UC
function getDocenteRespId() {
    const docRespSelect = document.querySelector('#uc-main-teacher-select');
    return docRespSelect.value;
}
function getRestantesDocsIds() {
    const restDocsSelects = document.querySelectorAll('select:not(:is([id="uc-acn-select"], [id="uc-main-teacher-select"]))')
    return Array.from(restDocsSelects).map(s => s.value);
}

console.log(getDocenteRespId());
console.log(getRestantesDocsIds());


// const selectedDocIds = Array.from(document.querySelectorAll('select:not(:is([id="uc-acn-select"]))'))
//     .map(select => select.value)
//     .filter(id => id != '')
//     .map(id => parseInt(id));

// console.log(selectedDocIds);


const docentesSelect = Array.from(document.querySelectorAll('select:not(:is([id="uc-acn-select"]))'));

function updateDisabledOptions() {
    docentesSelect.forEach(s => {
        if (s.id === 'uc-main-teacher-select')
            disableOptionsForDocenteResponsavel(s);
        else
            disableOptionsForRestantesDocentes(s);


        // Array.from(s.querySelectorAll('option:not(:first-child)')).forEach(opt => {
        //     if ((getRestantesDocsIds().includes(opt.value) && opt.value !== '') || (getDocenteRespId() == opt.value && opt.value !== '')) {
        //         opt.disabled = true
        //     }
        // })
    })
}

document.addEventListener('DOMContentLoaded', updateDisabledOptions);

docentesSelect.forEach((select) => {
    select.addEventListener('change', updateDisabledOptions);
});

function disableOptionsForDocenteResponsavel(select) {
    const options = Array.from(select.querySelectorAll('option:not(:first-child)'));

    options.forEach(opt => {
        if (getRestantesDocsIds().includes(opt.value) && opt.value !== '')
            opt.disabled = true;
        else
            opt.disabled = false;
    })
}

function disableOptionsForRestantesDocentes(select) {
    const options = Array.from(select.querySelectorAll('option:not(:first-child)'));

    options.forEach(opt => {
        if (opt.value === getDocenteRespId() || (getRestantesDocsIds().includes(opt.value) && !opt.selected))
            opt.disabled = true;
        else
            opt.disabled = false;
    })
}