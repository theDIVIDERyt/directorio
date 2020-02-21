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
<button type="button" onclick="mostrarModal()">Nuevo Contacto</button>
</div>

<?php 
include "conexion.php";
?>

<section class="botonera">
    <?php

        for ($i=65; $i<=90; $i++){
            echo "<button type='button' onClick=mostrarResultados('".chr($i)."')>".chr($i)."</button>";
        }
    ?>
</section>

<section class="busquedas">
    <form method="post" action="index.php">
        <input type="text" class="campo" name="busqueda"/>
        <button type="submit" class="boton"><i class="fas fa-search"></i></button>
    </form>
</section>

<?php
    //checamos si se ha enviado un querystring a la página o el formulario con una búsqueda
    if (isset($_REQUEST["letra"])){
        $letraParaBuscar = $_REQUEST["letra"];

        //buscamos los apellidos que inician con la letra seleccionada
        $sql = "select idDirectorio, nombre, apellido from paulina_directorio where apellido like '".$letraParaBuscar."%' order by apellido";
        $rs = ejecutar($sql);

    }else if (isset($_POST["busqueda"])){
        $registroParaBuscar = $_POST["busqueda"];

        $sql = "select idDirectorio, nombre, apellido from paulina_directorio where apellido like '".$registroParaBuscar."%' order by apellido";
        $rs = ejecutar($sql);
    }
?>

<section class="listaResultados">
    <div class = "contenedor" id="contenedor">
        <?php
        if (isset($_REQUEST["letra"]) || isset($_POST["busqueda"])){
            echo '<div id="r1">Registros encontrados: </div>';
            echo '<ul class="listaNombres">';

            //checamos si la búsqueda realizada encontró registros en la BD
             if (mysqli_num_rows($rs) != 0){
                $k = 0;
                while ($datos = mysqli_fetch_array($rs)){
                    if ($k % 2 == 0){
                        echo "<li class='oscuro'>";
                    }else{
                        echo "<li class='claro'>";
                    }
                    echo "<a href='javascript:mostrarRegistro(".$datos['idDirectorio'].")'>".$datos["apellido"]."</a>, ".$datos["nombre"]."</li>";
                    $k++;
                }
            }else{
                echo 'No se encontraron registros con la búsqueda realizada';
            }

            echo "</ul>";

        }else if (isset($_REQUEST["id"])){
            // checamos si se ha enviado un id para buscar un registro en particular
            $id = $_REQUEST["id"];

            //hacemos un query para obtener toda la información del registro que se desea deplegar
            $sql = "select * from paulina_directorio where idDirectorio =".$id;

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
            <div class="titulo"><?php echo $datosRegistro["nombre"]." ".$datosRegistro["apellido"];?></div>
            
            <div class="iconos"><i class="fas fa-building"></i></div>
            <div class="datos"><?php echo $datosRegistro["empresa"];?></div>
            <div class="foto">
                <?php
                // checamos si existe una foto para este registro. Si no existe, colocamos la imagen de no foto
                if ($datosRegistro["foto"] == null){
                    echo "<img src='fotos/noFoto.png' class='fotoRegistro'>";
                }else{
                    //colocamos la foto del registro
                }
                ?>
            </div>

            <div class="iconos"><i class="fas fa-envelope"></i></div>
            <div class="datos"><?php echo $datosRegistro["email"];?></div>

            <div class="iconos"><i class="fas fa-phone"></i></div>
            <div class="datos"><?php echo $datosRegistro["telefono"];?></div>

            <div class="iconos"><i class="fas fa-comment"></i></div>
            <div class="datos"><?php echo $datosRegistro["comentarios"];?></div>
            

        </div>
        <button type="button"><i class="fas fa-caret-square-right"></i></button>
            
    </div>
    
    <?php
    if (isset($_REQUEST["id"])){
        echo '<script language="javascript">mostrarDatosIndividuales()</script>';
    }
    ?>
    

</section>

<div class="modal" id="formulario">
    <div class="modal-bg">
        <form method="post">
        <div class="modal-container"> 
            <div class="cerrar">
                <button type="button" onclick="ocultarModal()" class="botonCerrarForm"><i class="fas fa-window-close"></i></button>
            </div>
            <h2 class="nuevoRegistro">Ingreso Nuevo Registro</h2>
            <div class="iconoForm"><i class="fas fa-user"></i></div>
            <p class="campo">
                <label for="first_name"></label><br>
                <input class="celda" id="nombre" name="first_name" placeholder="Nombre" type="text">
            </p>
            <div class="iconoForm"><i class="fas fa-user"></i></div>
            <p class="campo">
                <label for="last_name"></label><br>
                <input class="celda" id="apellido" name="last_name" placeholder="Apellido" type="text">
            </p>
            <div class="iconoForm"><i class="fas fa-building"></i></div>
            <p class="campo">
                <label for="empresa"></label><br>
                <input class="celda" id="empresa" name="empresa" placeholder="Empresa" type="text">
            </p>
            <div class="iconoForm"><i class="fas fa-envelope"></i></div>
            <p class="campo">
                <label for="email"></label><br>
                <input class="celda" id="email" name="email" placeholder="E-mail" type="text">
            </p>
            <div class="iconoForm"><i class="fas fa-phone"></i></div>
            <p class="campo">
                <label for="telephone"></label><br>
                <input class="celda" id="telefono" name="telephone" placeholder="Teléfono" type="number">
            </p>
            <div class="iconoForm"><i class="fas fa-comment"></i></div>
            <p class="campo">
                <label for="comments"></label><br>
                <textarea class="celdaComentarios" name="comments" maxlength="500" cols="40" rows="5"></textarea>
            </p>
            <input type="button" class="ingresar" onclick="validarFormulario()" value="Ingresar">
        </form>
        <ul class="mensajeError" id="msj">
            
        </ul>    
        </div>
    </div>
</div>



</body>
</html>