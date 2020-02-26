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
        <button type="button" class="button" onClick="abrirNuevoContacto()">Nuevo Contacto</button>
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
        $sql = "select idDirectorio, nombre, apellido from georgia_directorio where apellido like '" . $letraParaBuscar . "%' order by apellido";
        $rs = ejecutar($sql);
    } else if (isset($_POST["busqueda"])) {
        $registroParaBuscar = $_POST["busqueda"];

        $sql = "select idDirectorio, nombre, apellido from georgia_directorio where apellido like '" . $registroParaBuscar . "%' order by apellido";
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
                $sql = "select * from georgia_directorio where idDirectorio =" . $id;

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
            <form>
                <div class="modal-container">
                    <div class="cerrarNuevo">
                        <button type="button" onClick="cerrarNuevoContacto()"><i class="fas fa-window-close"></i></button>
                    </div>


                    <div class="Titulo">Ingreso Nuevo Registro</div>

                    <div class="iconosNC"><i class="fas fa-user"></i></div>
                    <div class="datos">
                        <input type="text" id="nombreNC" name="nombreNC" placeholder="Nombre" />
                    </div>

                    <div class="iconosNC"><i class="fas fa-user"></i></div>
                    <div class="datos">
                        <input type="text" id="apellidoNC" name="apellidoNC" placeholder="Apellido" />
                    </div>

                    <div class="iconosNC"><i class="fas fa-building"></i></div>
                    <div class="datos">
                        <input type="text" id="empresa" name="nombreNC" placeholder="Empresa" />
                    </div>

                    <div class="iconosNC"><i class="fas fa-envelope"></i></div>
                    <div class="datosNC">
                        <input type="text" id="email" name="emailNC" placeholder="Email" />
                    </div>

                    <div class="iconosNC"><i class="fas fa-phone"></i></div>
                    <div class="datosNC">
                        <input type="text" id="telefono" name="telefonoNC" placeholder="Teléfono" />
                    </div>

                    <div class="iconosNC"><i class="fas fa-comment"></i></div>
                    <div class="datosNC">
                        <textarea id="comentario" rows="5" cols="40"></textarea>
                    </div>

                    <div class="iconosNC"></div>
                    <div class="validar">
                        <button type="submit" class="botonNC" onclick="validarFormulario()"><span class="botonH">Ingresar</span></button>
                    </div>

                    <div class="iconosNC"></div>
                    <div class="mensaje" id="mensaje">
                        <ul id="msj"></ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_REQUEST["id"])) {
        echo '<script language="javascript">nuevoContacto()</script>';
    }
    ?>

</body>

</html>