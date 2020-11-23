<?php
    include 'conexion.php';
    include 'includes/header.php';
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        // Consulta info del id padre
        $querySelectInfo = "SELECT * FROM directorios WHERE id = $id";
        $respuestaInfo = mysqli_query($con, $querySelectInfo);

        $rowInfo = mysqli_fetch_array($respuestaInfo);

        // Consulta info de los hijos del id padre
        $querySelectInfoHijos = "SELECT * FROM directorios WHERE padre_id = $id";
        $respuestaInfoHijos = mysqli_query($con, $querySelectInfoHijos);

        $numRows = mysqli_num_rows($respuestaInfoHijos);

        // Eliminación
        if($rowInfo['tipo'] != "Carpeta" || ( ($rowInfo['tipo'] == "Carpeta") && ($numRows == 1) ) ) {
            $queryDelete = "DELETE FROM directorios WHERE id = $id";

            $respuesta = mysqli_query($con, $queryDelete);

            if(!$respuesta){
                $_SESSION['message'] = "Error al eliminar el archivo";
                $_SESSION['message_type'] = "error";

                header("Location: listarSeccion.php?id=1");
            }

            $_SESSION['message'] = "Archivo eliminado correctamente";
            $_SESSION['message_type'] = "success";

            header("Location: listarSeccion.php?id=1");
        } else{
            while($rowInfoHijos = mysqli_fetch_array($respuestaInfoHijos)){
                    $queryDelete = "DELETE FROM directorios WHERE id = $rowInfoHijos[0]";

                    $respuesta = mysqli_query($con, $queryDelete);

                    $numRows--;
                    if($numRows == 0){
                        $queryDelete = "DELETE FROM directorios WHERE id = $id";
                        $respuesta = mysqli_query($con, $queryDelete);
                        
                    if(!$respuesta){
                        $_SESSION['message'] = "Error al eliminar el archivo";
                        $_SESSION['message_type'] = "error";
            
                        header("Location: listarSeccion.php?id=1");
                    }
            
                    $_SESSION['message'] = "Archivo eliminado correctamente";
                    $_SESSION['message_type'] = "success";
            
                    header("Location: listarSeccion.php?id=1");
                }
            }
        }
    }
?>



<?php include 'includes/footer.php'; ?>