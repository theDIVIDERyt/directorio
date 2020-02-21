<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Directorio</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://kit.fontawesome.com/5637dd924f.js" crossorigin="anonymous"></script>
    <script src="./scripts.js"></script>
</head>

<body>
    <div class="header">
        <h1>Directorio</h1>
        <button type="button" class="button" onclick="abrirNuevoContacto()">Nuevo Contacto</button>
    </div>

    <?php
    include "conexion.php";
    ?>

    <section class="botonera">
        <?php

        for ($i = 65; $i <= 90; $i++) {
            echo "<button type='button' onClick=mostrarResultados('" . chr($i) . "')>" . chr($i) . "</button>";
        }
        ?>
    </section>

    <section class="busquedas">
        <form method="post" action="index.php">
            <input type="text" class="campo" name="busqueda" />
            <button type="submit" class="boton"><i class="fas fa-search"></i></button>
        </form>
    </section>

    <?php
    //checamos si se ha enviado un querystring a la página o el formulario con una búsqueda
    if (isset($_REQUEST["letra"])) {
        $letraParaBuscar = $_REQUEST["letra"];

        //buscamos los apellidos que inician con la letra seleccionada
        $sql = "select idDirectorio, nombre, apellido from andres_directorio where apellido like '" . $letraParaBuscar . "%' order by apellido";
        $rs = ejecutar($sql);
    } else if (isset($_POST["busqueda"])) {
        $registroParaBuscar = $_POST["busqueda"];

        $sql = "select idDirectorio, nombre, apellido from andres_directorio where apellido like '" . $registroParaBuscar . "%' order by apellido";
        $rs = ejecutar($sql);
    }
    ?>

    <section class="listaResultados">
        <div class="contenedor" id="contenedor">
            <?php
            if (isset($_REQUEST["letra"]) || isset($_POST["busqueda"])) {
                echo '<div id="r1">Registros encontrados: </div>';
                echo '<ul class="listaNombres">';

                //checamos si la búsqueda realizada encontró registros en la BD
                if (mysqli_num_rows($rs) != 0) {
                    $k = 0;
                    while ($datos = mysqli_fetch_array($rs)) {
                        if ($k % 2 == 0) {
                            echo "<li class='oscuro'>";
                        } else {
                            echo "<li class='claro'>";
                        }
                        echo "<a href='javascript:mostrarRegistro(" . $datos['idDirectorio'] . ")'>" . $datos["apellido"] . "</a>, " . $datos["nombre"] . "</li>";
                        $k++;
                    }
                } else {
                    echo 'No se encontraron registros con la búsqueda realizada';
                }

                echo "</ul>";
            } else if (isset($_REQUEST["id"])) {
                // checamos si se ha enviado un id para buscar un registro en particular
                $id = $_REQUEST["id"];

                //hacemos un query para obtener toda la información del registro que se desea deplegar
                $sql = "select * from andres_directorio where idDirectorio =" . $id;

                //ejecutamos el query
                $rs = ejecutar($sql);

                $datosRegistro = mysqli_fetch_array($rs);
            } else {
                echo '<div id="r1">Seleccione una letra o realize una búsqueda para desplegar los registros del directorio</div>';
            }
            ?>
        </div>

        <div class="contenedorRegistro" id="registro">
            <button type="button"><i class="fas fa-caret-square-left"></i></button>
            <div class="registro">
                <div class="cerrar">
                    <button type="button" onClick="ocultarTarjeton()">
                        <i class="fas fa-window-close"></i></button>
                </div>
                <div class="titulo"><?php echo $datosRegistro["nombre"] . " " . $datosRegistro["apellido"]; ?></div>

                <div class="iconos"><i class="fas fa-building"></i></div>
                <div class="datos"><?php echo $datosRegistro["empresa"]; ?></div>
                <div class="foto">
                    <?php
                    // checamos si existe una foto para este registro. Si no existe, colocamos la imagen de no foto
                    if ($datosRegistro["foto"] == null) {
                        echo "<img src='fotos/noFoto.png' class='fotoRegistro'>";
                    } else {
                        //colocamos la foto del registro
                    }
                    ?>
                </div>

                <div class="iconos"><i class="fas fa-envelope"></i></div>
                <div class="datos"><?php echo $datosRegistro["email"]; ?></div>

                <div class="iconos"><i class="fas fa-phone"></i></div>
                <div class="datos"><?php echo $datosRegistro["telefono"]; ?></div>

                <div class="iconos"><i class="fas fa-comment"></i></div>
                <div class="datos"><?php echo $datosRegistro["comentarios"]; ?></div>


            </div>
            <button type="button"><i class="fas fa-caret-square-right"></i></button>

        </div>

        <?php
        if (isset($_REQUEST["id"])) {
            echo '<script language="javascript">mostrarDatosIndividuales()</script>';
        }
        ?>


    </section>

    <div class="modal" id="modal">
        <div class="modal-bg">
            <div class="modal-container">
                <button type="button" onclick="cerrarNuevoContacto()">Cerrar modal</button>

                <body>
                    <form>
                        <fieldset>
                            <legend>Ingresa tus datos</legend>
                            <p>
                                <label for="first_name">Nombre: *</label>
                                <input name="first_name" type="text" required placeholder="Ingresa tu nombre">
                            </p>
                            <p>
                                <label for="last_name">Apellido: *</label>
                                <input name="last_name" type="text" required placeholder="Ingresa tu apellido">
                            </p>
                            <p>
                                <label for="email">Dirección de E-mail: *</label>
                                <input name="email" type="email" required placeholder="Ingresa tu correo">
                            </p>
                            <p>
                                <label for="telefono">Número de teléfono:</label>
                                <input name="telefono" type="number" required placeholder="Ingresa tu número telefónico">
                            </p>
                        </fieldset>
                    </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_REQUEST["id"])) {
        echo '<script language="javascript">abrirNuevoContacto()</script>';
    }
    ?>

</body>

</html>