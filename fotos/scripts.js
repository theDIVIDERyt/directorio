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
    //definimos accesos a los campos del formulario 
    var campoNombre = document.getElementById('nombreNC');
    var campoApellido = document.getElementById('apellidoNC');
    var email = document.getElementById("email").value;
    var campoTelefono = document.getElementById('telefono');

    // leemmos los valores de los campos 
    var nombre = campoNombre.value;
    var apellido = campoApellido.value;
    var telefono = campoTelefono.value;

    //creamos una badera que nos va a indicar la falta llenar algun campo
    var flag = false;

    // declaramos un arreglo para los mensajes de validación
    var mensaje = new Array();


    //correo: declaramos la banderas que validan cada condición
    var flagPrimerCaracter = false;
    var flagArroba = false;
    var flagPosicionArroba = false;
    var flagUltimoPunto = false;
    var flagNumCaracteres = false;



    // checamos si los campos contienen informacion, si no la tienen cambiamos su color 

    if (nombre == "") {
        campoNombre.style.backgroundColor = "coral";
        flag = true;
        mensaje.push("Completa correctamente el campo de nombre");
    } else {
        campoNombre.style.backgroundColor = 'white';
    }

    if (apellido == "") {
        campoApellido.style.backgroundColor = "coral";
        flag = true;
        mensaje.push("Completa correctamente el campo de apellido");
    } else {
        campoApellido.style.backgroundColor = 'white';

    }






    if (email == "") {
        email.style.backgroundColor = "coral";
        flag = true;
    } else {
        campoEmail.style.backgroundColor = 'white';
    }
    //checamos la longitud del email ingresado
    var n = email.length;
    if (n < 6) {
        flagNumCaracteres = true;
        mensaje.push("El email ingresado no tiene más de 6 caracteres");
    }

    //checamos que el primer caracter sea una letra mayúscula o minúscula
    var primerCaracter = email.charCodeAt(0);
    if ((primerCaracter >= 65 && primerCaracter <= 90) || (primerCaracter >= 97 && primerCaracter <= 122)) {
        // no hacemos nada, está correcto
    } else {
        flagPrimerCaracter = true;
        mensaje.push("El primer caracer no es una letra");
    }

    // checamos el número de @
    var numArrobas = 0;
    for (var i = 0; i < n; i++) {
        if (email.charAt(i) == "@") numArrobas++;
    }
    if (numArrobas != 1) {
        flagArroba = true;
        mensaje.push("El email ingresado contiene más de una @");
    }

    //checamos  posición de la arroba si tenemos solo una arroba
    if (!flagArroba) {
        var posArroba = email.indexOf("@");
        if (posArroba >= 1 && posArroba <= email.length - 5) {
            //esta correcto
        } else {
            flagPosicionArroba = true;
            mensaje.push("La arroba no se encuentra en una posición válida");
        }
    }

    // checamos la posición del último punto
    var ultimoPunto = email.lastIndexOf(".");
    if ((ultimoPunto >= email.length - 5 && ultimoPunto <= email.length - 3) && ultimoPunto != -1) {
        //posición correcta
    } else {
        flagUltimoPunto = true;
        mensaje.push("El último punto del email tiene una posición inválida");
    }

    //checamos el estado de las banderas
    if (!flagUltimoPunto && !flagNumCaracteres && !flagPosicionArroba && !flagPrimerCaracter && !flagArroba) {
        //borramos los mensajes de la lista de errores si es que existen
        document.getElementById("msj").innerHTML = "";
        //añadimos a la lista de errores, un elemento que indica que el email ingresado es correcto
        var li = document.createElement("li");
        li.innerHTML = "<span class='mensaje'>El formulario fue llenado carectamente</span></li>";
        document.getElementById("msj").appendChild(li);
    } else {
        //corremos una función que lee los mensajes de arreglo mensaje, y los imprime como una lista dentro del tag ul
        imprimirErrores(mensaje);
    }







    if (telefono == "") {
        campoTelefono.style.backgroundColor = "coral";
        flag = true;
        mensaje.push("Completa correctamente el campo de telefono");
    } else {
        campoTelefono.style.backgroundColor = 'white';
    }

    //checamos el estado de la bandera para imprimir un mensaje en el formulario
    if (flag) {
        document.getElementById('mensaje').innerHTML = "Llene todos  los campos para mandar le fomrulario";
    } else {
        document.getElementById("mensaje").innerHTML = "";
    }
}


function imprimirErrores(errores) {
    //borramos todos los errores impresos anteriormente, si es que existen
    var listaErrores = document.getElementById("msj");
    listaErrores.innerHTML = "";

    //leemos el arreglo errores y por cada uno de sus elementos creamos un elemento li que añadimos al tag ul que
    //muestra la lista de errores

    errores.forEach(function (error) {
        var li = document.createElement("li");
        li.innerHTML = "<span class='error'>" + error + "</span>";
        listaErrores.appendChild(li);
    });
}