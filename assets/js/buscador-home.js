function llenar(select1, select2) {
    var s1 = document.getElementById(select1);
    var s2 = document.getElementById(select2);
    s2.innerHTML = "";
    if (s1.value == "playa") {
        var optionArray = [
            "0|SELECCIONA UN DESTINO", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-acapulco.php|ACAPULCO", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-cancun.php|CANCÚN", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-ixtapa.php|IXTAPA", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-cabos.php|LOS CABOS", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-manzanillo.php|MANZANILLO" ,
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-nuevo-vallarta.php|NUEVO VALLARTA", 
            "/paquetes/boda-de-tus-suenos/boda-de-tus-suenos-puerto-vallarta.php|PUERTO VALLARTA" 
        ]
    }
    if (s1.value == "ciudad") {
        var optionArray = ["0|SELECCIONA UN DESTINO", "/destinos-ciudad/#guadalajara|GUADALAJARA", "/destinos-ciudad/#cdmx|CDMX"]
    }
    for (var option in optionArray) {
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        if(pair[0] == 0){
            newOption.disabled = true;
            newOption.selected = true;
        }
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        s2.options.add(newOption);
    }
}
var url = "";

function redireccionar() {
    var cod = document.getElementById("slct2").value;
    if (cod == 2) {
        alert('Por favor, elija PLAYA O CIUDAD')
    } else if (cod == 0) {
        alert('Por favor, elija un DESTINO. Gracias.')
    } else {
        window.location.href = url + cod;
    }
}