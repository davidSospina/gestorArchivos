<?php

	include 'conexion.php';
    include 'includes/header.php';
    
	$id=$_GET['id'];

?>

    <div class="container-fluid">
        <div class="text-center m-5">
            <h1>Gestor de archivos</h1>
            <h3>Estos son tus archivos</h3>
        </div>

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

        <div class="row">

            <div class="col-md-1">

            </div>

            <div class="col-md-10">

                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">¡Hola!</h4>
                        
                    <p>Este es un gestor de archivos creado para hacerte mas fácil tu día a día.</p>
                    <hr>
                    <h5 class="alert-heading">Ten en cuenta las siguientes instrucciones para aprovechar al maximo tu getsor online.</h5>
                    <p class="mb-0">
                        * Aquí podrás listar cada tus archivos por secciones o verlos todos en un solo lugar (en este caso las carpetas
                        no se listan). <br> <br> 
                        * Puedes editar (botón gris con un lapicero), o eliminar (botón rojo con un basurero) tus archivos.
                        <br>Sí eliminas una carpeta estarás eliminando todo lo que hay dentro de ella. <br> <br>
                        * Al oprimir el enlace de la columna 'Archivo' podrás ver o descargar los archivos que selecciones.</p>
                </div>

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <?php 
                                    $padre = mysqli_query($con,"SELECT * FROM directorios WHERE id=$id;");
                                    $row = mysqli_fetch_row($padre);

                                    if($id != 0){
                                        echo "<a class='btn btn-warning m-3' href='listarSeccion.php?id=$row[5]' role='button'> 
                                        <i class='fa fa-arrow-left'></i>  Regresar</a> 
                                        
                                        <a class='btn btn-success m-3' href='nuevoArchivo.php?padre_id=$id' role=button> 
                                        <i class='fa fa-plus'></i>  Nuevo</a>";
                                    }
                                    
                                ?>

                                
                            </li>
                        </ul>
                        <a class="btn btn-primary m-3" href="index.php" role="button"><i class="fa fa-inbox"></i>  Visualizar todos los archivos</a>
                    </div>
                </nav>

                <div>
                    <?php
                        if($id != 0){

                            echo "<p class='mt-3'> <b>$row[1]</b> </p>";
                        } 
                    ?>
                </div>

                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de carga</th>
                            <?php
                                if($row[0] == 0){
                                    
                                } else{
                                    echo "<th scope='col'>Archivo</th>
                                    <th scope='col'>Acciones</th>";
                                }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody>

                    <?php

						$respuesta = mysqli_query($con,"SELECT * FROM directorios WHERE padre_id=$id ORDER BY nombre;");

                        while($row = mysqli_fetch_array($respuesta)){
                        ?>
                        <tr>
							<td scope="row">
								<?php 
									switch ($row['tipo']) {
										case 'Carpeta':
											echo "<a href=listarSeccion.php?id=$row[0]> <img src=imagenes/carpeta.png> $row[1] </a> ";
											break;

										case 'Documento':
											echo "<img src=imagenes/documento.png> $row[1]";
											break;

										case 'Video':
											echo "<img src=imagenes/video.png> $row[1]";
											break;

										case 'Imagen':
											echo "<img src=imagenes/imagen.png> $row[1]";
											break;

										case 'Codigo':
											echo "<img src=imagenes/codigo.png> $row[1]";
											break;

										case 'Unidad':
											echo "<a href=listarSeccion.php?id=$row[0]> <img src=imagenes/unidadC.png> $row[1]  </a> ";
											break;
										
										default:
											echo "<img src=imagenes/archivo.png>";
											break;
                                    }
								?>
                            </td>
                            
                            <td><?php echo $row['tipo'] ?></td>
                            <td><?php echo $row['descripcion'] ?></td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td> 
                                <?php
                                
                                    if($row['tipo'] == "Carpeta"){
                                        echo $row['archivo_URL'];
                                    } else{
                                        echo "<a href='uploads/$row[4]' target='_blank'> $row[4] </a>";
                                    }

                                ?> 
                            </td>

                            <td>

                                <?php 
                                    if($row['padre_id'] != 0){

                                        echo "<a class='btn btn-outline-info btn-sm mr-2' href=editar.php?id=$row[0] role='button'><i class='fa fa-edit'></i></a>";
                                        
                                        echo "<button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#eliminar-$row[0]'>
                                        <i class='fa fa-trash'></i></button>";
                                    }
                                ?>

                                <!-- Modal Eliminar--> 
                                <div class="modal fade" aria-hidden="true" role="dialog" tabindex="-1"
                                    id="eliminar-<?php echo $row[0]; ?>">

                                    <form method="POST" action="eliminarArchivo.php?id=<?php echo $row['id']; ?>">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Eliminar</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Está seguro que desea eliminar <?php echo $row['nombre']; ?>?</p>
                                                </div>
                                                <div class="modal-footer" style="background-color:#E7E7E7">
                                                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-1">
            </div>
 
        </div>

    </div>

    <?php include 'includes/footer.php' ?>