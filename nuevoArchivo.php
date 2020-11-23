<?php
    include 'conexion.php';
    include 'includes/header.php';

    $padre_id = $_GET['padre_id'];

    
?>

    <?php 

    if(isset($_SESSION['message'])) {
        
        $message = $_SESSION['message'];
        $message_type = $_SESSION['message_type'];

    ?>

    <script>
    var message = "<?php echo $message; ?>";
    var message_type = "<?php echo $message_type; ?>";

    mostrarNotificacion(message, message_type);
    </script>

    <?php } session_unset(); ?>

    <div class="container-fluid m-3">
        <div class="text-center m-5">
            <h1>Bienvenido al gestor de archivos</h1>
            <h3>Nuevo archivo</h3>
        </div>

        <div class="row">
            <div class="col-md-3 text-center">
                <a class="btn btn-warning" href="javascript:history.go(-1)" role="button"> <i class='fa fa-arrow-left'></i>  Regresar</a>
            </div>

            <div class="col-md-6">
                <form enctype="multipart/form-data" action="formulario.php" method="POST">

                    <input type="hidden" name="padre_id" value=<?php echo $padre_id; ?>>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombreArchivo" placeholder="Nombre del archivo" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="tipoArchivo">Tipo de archivo</label>
                        <select class="form-control" id="tipoArchivo" name="tipoArchivo">
                            <option value="1">Carpeta</option>
                            <option value="2">Documento</option>
                            <option value="3">Imagen</option>
                            <option value="4">Video</option>
                            <option value="5">Código</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción del archivo</label>
                        <textarea class="form-control" id="descripcion" name="descripcionArchivo" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="archivo">Seleccione el archivo</label>
                        <input class="btn btn-info btn-block" type="file" name="archivo" class="form-control-file" id="archivo"
                               accept="image/png, image/jpeg, image/jpg, .doc, .docx, .mov, .mp4, .css, .html, .c, .js">
                    </div>

                    <input class="btn btn-success" type="submit" name="nuevo" value="Subir">
                    <input class="btn btn-warning" type="reset" value="Limpiar">
                </form>
            </div>


            <div class="col-md-3">

            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>