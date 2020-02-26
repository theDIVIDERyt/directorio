<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://kit.fontawesome.com/5637dd924f.js" crossorigin="anonymous"></script>
    <script src="./scripts.js"></script>
</head>

<body>
    <?php
    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];

        include "conexion.php";

        //hacemos un query para obtener el registro con el id seleccionado, que es el que se quiere editar
        //Buscamos el nombre del archivo en la BD que hay que sustituir
        $sql = "select * from andres_directorio where idDirectorio =" . $id;
        $rs = ejecutar($sql);

        //Como es un solo registro el que se encuentra, no hace falta ejecutar el lazo while para obtener la información guardada en el recordset
        $datos = mysqli_fetch_array($rs);
    ?>
        <div class="header">
            <h1>Directorio</h1>
        </div>

        <section class="listaResultados">
            <form method="post" action="editarRegistro_xt.php" id="f2">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <div class="modal-container">
                    <div class="cerrar">

                    </div>
                    <div class="titulo">Edición de Registro</div>

                    <div class="iconos"><i class="fas fa-user"></i></div>
                    <div class="formulario"><input type="text" placeholder="nombre" name="nombre" class="camposModal" id="c1" value="<?php echo $datos["nombre"]; ?>" /></div>

                    <div class="iconos"><i class="fas fa-user"></i></div>
                    <div class="formulario"><input type="text" placeholder="apellido" name="apellido" class="camposModal" id="c2" value="<?php echo $datos["apellido"]; ?>" /></div>

                    <div class="iconos"><i class="fas fa-building"></i></div>
                    <div class="formulario"><input type="text" placeholder="empresa" name="empresa" class="camposModal" id="c3" value="<?php echo $datos["empresa"]; ?>" /></div>

                    <div class="iconos"><i class="fas fa-envelope"></i></div>
                    <div class="formulario"><input type="text" placeholder="email" name="email" class="camposModal" id="c4" value="<?php echo $datos["email"]; ?>" /></div>

                    <div class="iconos"><i class="fas fa-phone"></i></div>
                    <div class="formulario"><input type="text" placeholder="telefono" name="telefono" class="camposModal" value="<?php echo $datos["telefono"]; ?>" /></div>

                    <div class="iconos"><i class="fas fa-comment"></i></div>
                    <div class="formulario"><textarea name="comentarios" rows="5" cols="40"><?php echo $datos["comentarios"]; ?></textarea></div>

                    <div class="iconos"></div>
                    <div class="formulario"><button type="button" class="botonFormularioModal" onClick="validarFormulario()">Ingresar</button>


                        <div class="iconos"></div>
                        <div class="formulario"><span id="msj" class="mensaje"></span></div>


                    </div>
            </form>

        </section>
    <?php
    } else {
        echo '<script language="javascript">';
        echo 'window.location.assign("index.php")';
        echo '</script>';
    }
    ?>

</body>

</html>