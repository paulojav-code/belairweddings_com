function lettersOnly(input) {
    var regex = /[^a-z]/gi;
    input.value = input.value.replace(regex, "");
}

function numbersOnly(input) {
    var regex = /[^0-9]/g;
    input.value = input.value.replace(regex, "");
}

function textsOnly(input) {
    var regex = /[^a-zA-Z0-9_""?¿1¡!., ]/gi;
    input.value = input.value.replace(regex, "");
}

function validarEmail(valor) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/.test(valor)) {
        alert("La dirección de email " + valor + "es correcta.");
    } else {
        alert("La dirección de email es incorrecta.");
    }
}