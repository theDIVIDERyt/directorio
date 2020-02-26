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
        <button type="button" onClick="abrirModal()">Nuevo Contacto</button>
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

        $sql = "select idDirectorio, nombre, apellido from andres_directorio where apellido like '%" . $registroParaBuscar . "%' order by apellido";
        $rs = ejecutar($sql);
    }
    ?>

    <section class="listaResultados">
        <div class="contenedor" id="contenedor">
            <?php
            if (isset($_REQUEST["letra"]) || isset($_POST["busqueda"])) {
                //checamos si hemos insertado un nuevo registro, para imprimir el mensaje
                //correspondiente
                if (isset($_REQUEST["accion"])) {
                    if ($_REQUEST["accion"] == "ingresar") {
                        echo '<div id="r1">Se insertó correctamente el registro en la BD </div>';
                    }
                } else {
                    echo '<div id="r1">Registros encontrados: </div>';
                }

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
                    echo 'No se encontraron registros con la letra ' . $letraParaBuscar;
                }

                echo "</ul>";
            } else if (isset($_REQUEST["id"])) {
                $id = $_REQUEST["id"];
                $sql = "select * from andres_directorio where idDirectorio =" . $id;
                $rs = ejecutar($sql);
                $registro = mysqli_fetch_array($rs);
            } else {
                echo '<div id="r1">Seleccione una letra o realize una búsqueda para desplegar los registros del directorio</div>';
            }
            ?>

        </div>


        <?php
        if (isset($_REQUEST["id"])) {
        ?>

            <div class="contenedorRegistro" id="registro">
                <button type="button"><i class="fas fa-caret-square-left"></i></button>
                <div class="registro">
                    <div class="cerrar">
                        <button type="button" onClick="editarRegistro(<?php echo $id; ?>)"><i class="fas fa-edit"></i></button>
                        <button type="button" onClick="cerrarTarjeton()"><i class="fas fa-window-close"></i></button>
                    </div>

                    <div class="nombre"><?php echo $registro["nombre"] . " " . $registro["apellido"]; ?> </div>

                    <div class="icono"><i class="fas fa-envelope"></i></div>
                    <div class="datos"><?php echo $registro["email"]; ?> </div>
                    <div class="foto">
                        <?php if ($registro["foto"] == null) {
                            echo "<img src='fotos/noFoto.png' class='fotoContacto'>";
                        }
                        ?>
                    </div>

                    <div class="icono"><i class="fas fa-building"></i></div>
                    <div class="datos"><?php echo $registro["empresa"]; ?> </div>

                    <div class="icono"><i class="fas fa-phone"></i></div>
                    <div class="datos"><?php echo $registro["telefono"]; ?> </div>

                    <div class="icono"><i class="fas fa-file-alt"></i></div>
                    <div class="datos"><?php echo $registro["comentarios"]; ?> </div>



                </div>
                <button type="button"><i class="fas fa-caret-square-right"></i></button>
            </div>
            <script language="javascript">
                mostrarDatosRegistro()
            </script>
        <?php
        }
        ?>

    </section>

    <div class="modal" id="vModal">
        <div class="modal-bg">
            <form method="post" action="index_xt.php" id="f2">
                <div class="modal-container">
                    <div class="cerrar">
                        <button type="button" onClick="cerrarModal()"><i class="fas fa-window-close"></i></button>
                    </div>
                    <div class="titulo">Ingreso Nuevo Registro</div>


                    <div class="iconos"><i class="fas fa-user"></i></div>
                    <div class="formulario"><input type="text" placeholder="nombre" name="nombre" class="camposModal" id="c1" /></div>

                    <div class="iconos"><i class="fas fa-user"></i></div>
                    <div class="formulario"><input type="text" placeholder="apellido" name="apellido" class="camposModal" id="c2" /></div>

                    <div class="iconos"><i class="fas fa-building"></i></div>
                    <div class="formulario"><input type="text" placeholder="empresa" name="empresa" class="camposModal" id="c3" /></div>

                    <div class="iconos"><i class="fas fa-envelope"></i></div>
                    <div class="formulario"><input type="text" placeholder="email" name="email" class="camposModal" id="c4" /></div>

                    <div class="iconos"><i class="fas fa-phone"></i></div>
                    <div class="formulario"><input type="text" placeholder="telefono" name="telefono" class="camposModal" /></div>

                    <div class="iconos"><i class="fas fa-comment"></i></div>
                    <div class="formulario"><textarea name="comentarios" rows="5" cols="40"></textarea></div>

                    <div class="iconos"></div>
                    <div class="formulario"><button type="button" class="botonFormularioModal" onClick="validarFormulario()">Ingresar</button>


                        <div class="iconos"></div>
                        <div class="formulario"><span id="msj" class="mensaje"></span></div>


                    </div>
            </form>
        </div>
    </div>



</body>

</html>