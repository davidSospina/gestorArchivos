<?php

include 'conexion.php';

if(isset($_POST['nuevo'])){

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["archivo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if( !empty($_POST['nombreArchivo']) && !empty($_POST['tipoArchivo']) ){
            
            $nombre = $_POST['nombreArchivo'];
            $tipo = $_POST['tipoArchivo'];
            $padre_id = $_POST['padre_id'];

            switch($tipo){
                case 1: $tipo = "Carpeta";
                    break;

                case 2: $tipo = "Documento";
                    break;

                case 3: $tipo = "Imagen";
                    break;

                case 4: $tipo = "Video";
                    break;
                
                case 5: $tipo = "Codigo";
                    break;

                case 6: $tipo = "Unidad";
                    break;
            }

        
            
        if( $tipo == "Carpeta" && (empty($_POST['descripcionArchivo']) || empty($_POST['archivo']) ) ){
            $descripcion = "Carpeta";
            $archivo = "NA";

            $sql = "INSERT INTO directorios (nombre, tipo, descripcion, archivo_URL, padre_id) VALUES ('$nombre', '$tipo', '$descripcion', '$archivo', '$padre_id')";

            if (mysqli_query($con, $sql)) {
                $_SESSION["message"] = "El archivo ".$tipo." se ha subido correctamente";
                $_SESSION["message_type"] = "success";
                header("Location:listarSeccion.php?id=$padre_id");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }

        } else if( $tipo != "Carpeta" ){
            
            if( !empty($_POST['descripcionArchivo']) ){
                $descripcion = $_POST['descripcionArchivo'];
            }
            
            if( !empty(basename( $_FILES["archivo"]["name"])) ){
                $archivo = basename( $_FILES["archivo"]["name"]);
            }

            if( !empty($_POST['descripcionArchivo']) &&  empty(basename( $_FILES["archivo"]["name"]))  ){
                $_SESSION["message"] = "Por favor seleccione el archivo a subir";
                $_SESSION["message_type"] = "error";
                header("Location:nuevoArchivo.php?padre_id=".$padre_id);
            } else if( empty($_POST['descripcionArchivo']) && !empty(basename( $_FILES["archivo"]["name"])) ){
                $_SESSION["message"] = "Por favor ingrese una descripción para el archivo";
                $_SESSION["message_type"] = "error";
                header("Location:nuevoArchivo.php?padre_id=".$padre_id);
            } else if( empty($_POST['descripcionArchivo']) && empty(basename( $_FILES["archivo"]["name"])) ){
                $_SESSION["message"] = "Por favor ingrese una descripción para el archivo y seleccione el archivo a subir";
                $_SESSION["message_type"] = "error";
                header("Location:nuevoArchivo.php?padre_id=".$padre_id);
            } else{
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
                    //echo "The file ". htmlspecialchars( basename( $_FILES["archivo"]["name"])). " has been uploaded.";
                
                    //$archivo = basename( $_FILES["archivo"]["name"]);
                    $sql = "INSERT INTO directorios (nombre, tipo, descripcion, archivo_URL, padre_id) VALUES ('$nombre', '$tipo', '$descripcion', '$archivo', '$padre_id')";

                    if (mysqli_query($con, $sql)) {
                        $_SESSION["message"] = "El archivo ".$tipo." se ha subido correctamente";
                        $_SESSION["message_type"] = "success";
                        header("Location:listarSeccion.php?id=$padre_id");
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($con);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }

    }
}

    
?>