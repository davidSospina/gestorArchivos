<?php
    include 'conexion.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $query = "SELECT * FROM directorios WHERE id = $id";
        $respuesta = mysqli_query($con, $query);

        if(mysqli_num_rows($respuesta) == 1){
            $row = mysqli_fetch_array($respuesta);
            $nombre = $row['nombre'];
            $tipo = $row['tipo'];
            $descripcion = $row['descripcion'];
            $archivo_url = $row['archivo_URL'];
            $padre_id = $row['padre_id'];
        }
    }

    if(isset($_POST['actualizar'])){
        $nombreActualizar = $_POST['nombreArchivo'];
        $descripcionActualizar = $_POST['descripcionArchivo'];

        $query = "UPDATE directorios SET nombre = '$nombreActualizar', descripcion = '$descripcionActualizar' WHERE id = $id";
        mysqli_query($con, $query);

        if(!$respuesta){
            $_SESSION['message'] = "Ha ocurrido un error actualizando el archivo";
            $_SESSION['message_type'] = "error"; 
            header("Location: listarSeccion.php?id=$padre_id");
        } else{
            $_SESSION['message'] = "Se ha actualizado correctamente el archivo";
            $_SESSION['message_type'] = "success"; 
            header("Location: listarSeccion.php?id=$padre_id");
        }
    }
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="text-center m-5">
        <h1>Gestor de archivos</h1>
        <h3>Actualizando el archivo '<?php echo $nombre; ?>'</h3>
    </div>

    <div class="row">
            <div class="col-md-3 text-center">
                <a class="btn btn-warning" href=<?php echo "listarSeccion.php?id=".$padre_id ?> role="button"><i class='fa fa-arrow-left'></i>  Regresar</a>
            </div>

            <div class="col-md-6">
                <form action="editar.php?id=<?php echo $id; ?>" method="POST">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombreArchivo" placeholder="Nombre del archivo" value="<?php echo $nombre; ?>" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="tipoArchivo">Tipo de archivo</label>
                        
                        <select class="form-control" id="tipoArchivo" name="tipoArchivo" readonly>
                            <?php
                            
                                switch($tipo){
                                    case "Carpeta": echo "<option selected>Carpeta</option>";
                                        break;

                                    case "Documento": echo "<option selected>Documento</option>";
                                        break;

                                    case "Imagen": echo "<option selected>Imagen</option>";
                                        break;

                                    case "Video": echo "<option selected>Video</option>";
                                        break;

                                    case "Codigo": echo "<option selected>Código</option>";
                                        break;

                                }

                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción del archivo</label>
                        <textarea class="form-control" id="descripcion" name="descripcionArchivo" rows="3"><?php echo $descripcion; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="archivo">Nombre del archivo subido</label>
                        <input class="form-control" type="text" name="archivo" id="archivo" value="<?php echo $archivo_url; ?>" readonly>
                    </div>

                    <input class="btn btn-success" type="submit" name="actualizar" value="Actualizar">
                    <a class="btn btn-danger" href=<?php echo "listarSeccion.php?id=".$padre_id ?> role="button"> Cancelar</a>
                    
                </form>
            </div>


            <div class="col-md-3">

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>