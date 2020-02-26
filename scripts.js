function mostrarRegistro(id) {
    document.location.assign("index.php?id=" + id);
}

function mostrarDatosRegistro() {
    document.getElementById("contenedor").style.display = "none";
    document.getElementById("registro").style.display = "flex";
}

function mostrarResultados(letraEscogida) {
    document.location.assign("index.php?letra=" + letraEscogida);
}

function cerrarTarjeton() {
    document.location.assign("index.php");
}

function abrirModal() {
    document.getElementById("vModal").style.display = "block";
    ocument.getElementById("msj").innerHTML = "";

}

function cerrarModal() {
    document.getElementById("vModal").style.display = "none";

}

function validarFormulario() {
    var flag = false;
    for (var i = 1; i < 5; i++) {
        if (document.getElementById("c" + i).value == "") flag = true;
    }

    if (flag) {
        document.getElementById("msj").innerHTML = "Debe llenar los campos nombre, apellido, empresa e email";
    } else {
        document.getElementById("msj").innerHTML = "";
        //hacemos el submit del formulario
        document.getElementById("f2").submit();
    }

}

function editarRegistro(id) {
    //redirigimos la página para editar el registro con el id seleccionado
    window.location.assign("editarRegistro.php?id=" + id);
}