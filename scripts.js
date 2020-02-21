function mostrarRegistro(id) {
    document.location.assign("index.php?id=" + id);
}

function mostrarResultados(letraEscogida) {
    document.location.assign("index.php?letra=" + letraEscogida);
}

function mostrarDatosIndividuales() {
    document.getElementById("contenedor").style.display = "none";
    document.getElementById("registro").style.display = "flex";
}

function ocultarTarjeton() {
    //recarga la página
    document.location.assign("index.php");
}

function abrirNuevoContacto() {
    document.getElementById("modal").style.display = "block";
}

function cerrarNuevoContacto() {
    document.getElementById("modal").style.display = "none";
}

function validarFormulario() {
    var nombre, apellido, email, empresa;
    nombre = document.getElementById("nombre").value;
    apellido = document.getElementById("apellido").value;
    email = document.getElementById("email").value;
    empresa = document.getElementById("empresa").value;
    var mensaje = new Array();
    var flagCampos = false;

    if (nombre == "" || apellido == "" || email == "" || empresa == "") {
        flagCampos = true;
        mensaje.push("Llene todos los campos");
    }

    var flagPrimerCaracter = false;
    var flagArroba = false;
    var flagPosicionArroba = false;
    var flagUltimoPunto = false;
    var flagNumCaracteres = false;
    var n = email.length;
    if (n < 6) {
        flagNumCaracteres = true;
    }


    var primerCaracter = email.charCodeAt(0);
    if ((primerCaracter >= 65 && primerCaracter >= 90) || (primerCaracter >= 97 && primerCaracter <= 122)) {
        //no hacemos nada, esta correcto
    } else {
        flagPrimerCaracter = true;
    }


    var numArrobas = 0;
    for (var i = 0; i < n; i++) {
        if (email.charAt(i) == "@") numArrobas++;
    }
    if (numArrobas != 1) {
        flagArroba = true;
    }


    if (!flagArroba) {
        var posArroba = email.indexOf("@");
        if (posArroba >= 1 && posArroba <= email.length - 5) {
            //correcto
        } else {
            flagPosicionArroba = true;
        }
    }

    var ultimoPunto = email.lastIndexOf(".");
    if ((ultimoPunto >= email.length - 5 && ultimoPunto <= email.length - 3) && ultimoPunto != 1) {
        //correcto
    } else {
        flagUltimoPunto = true;
    }

    if ((flagUltimoPunto) || (flagNumCaracteres) || (flagPosicionArroba) || (flagPrimerCaracter) || (flagArroba)) {
        mensaje.push("El email ingresado es inválido");
    }

    if (!flagCampos && !flagUltimoPunto && !flagNumCaracteres && !flagPosicionArroba && !flagPrimerCaracter && !flagArroba) {
        //borramos los mensajes de la lista de errores si es que existen
        document.getElementById("msj").innerHTML = "";

        //añadimos a la lista de errores, un elemento que indica que el primer ingresado es correcto
        alert("Todo bien");
    } else {
        //corremos una funcion que lee los mensajes del arreglo mensaje, y los imprime como una lista dentro del ul
        imprimirErrores(mensaje);
    }
}


function imprimirErrores(errores) {
    //borramos todos lo errores impresos anteriormente si es que existen
    var listaErrores = document.getElementById("msj");
    listaErrores.innerHTML = "";

    //leemos el arreglo errores y por cada uno de sus elementos creamos un elemento li que añadimos al tag ul que representa o muestra la lista de errores
    errores.forEach(function (error) {
        var li = document.createElement("li");
        li.innerHTML = "<span class = 'error'>" + error + "</span>";
        listaErrores.appendChild(li);
    });
}