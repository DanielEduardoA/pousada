function validaData(campo, valor) {
    var date = valor;
    var ardt = new Array;
    var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
    ardt = date.split("/");
    erro = false;
    if (date.search(ExpReg) == -1) {
        erro = true;
    } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
        erro = true;
    else if (ardt[1] == 2) {
        if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
            erro = true;
        if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
            erro = true;
    }
    if (erro) {
        alert("Data inválida!");
    }
}

function validaDataHora(valor) {
    var matches = valor.match(/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/);
    if (matches === null) {
        alert("Data/hora inválida!");
    } else {
        var year = parseInt(matches[3], 10);
        var month = parseInt(matches[2], 10) - 1; // months are 0-11
        var day = parseInt(matches[1], 10);
        var hour = parseInt(matches[4], 10);
        var minute = parseInt(matches[5], 10);
        var date = new Date(year, month, day, hour, minute);
        if (date.getFullYear() !== year ||
            date.getMonth() != month ||
            date.getDate() !== day ||
            date.getHours() !== hour ||
            date.getMinutes() !== minute
        ) {
            alert("Data/hora inválida!");
        }
    }
}