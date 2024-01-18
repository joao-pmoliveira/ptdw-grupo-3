'use strict'

//todo @joao: atualizar para que funcione da mesma maneira do que 'editarUC'
const docentesSelect = Array.from(document.querySelectorAll('select:not(:is([id="uc-acn-select"]))'));
docentesSelect.forEach((select) => {
    select.addEventListener('change', () => {
        if (select.value === '')
            return

        docentesSelect.forEach((s) => {
            if (select === s)
                return

            if (select.value === s.value)
                s.value = ''
        })
    });
});