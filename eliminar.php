<?php

    include 'conexion.php';
    $id = $_GET['id'];

    //echo "<script>alert( $id );</script>";

    $sql_select = "SELECT * FROM directorios WHERE padre_id=$id";

    $respuesta_select = mysqli_query($con, $sql_select);
    $directorios = array();

    while($row = mysqli_fetch_row($respuesta_select)){
        $directorios[] = $row;
    }

    // $respuesta_select->close();

    for($i = 0 ; $i < count($directorios) ; $i++){
        if($directorios[$i][2] == "Carpeta"){
            $carpeta = $directorios[$i];
            $cont = 0;
            while(true){
                $sql_select2 = "SELECT * FROM directorios WHERE padre_id=$carpeta[0]";
                $respuesta_select = mysqli_query($con, $sql_select2);
                $directorios2 = array();
                while($row = mysqli_fetch_row($respuesta_select))
                    $directorios2[] = $row;
                $sql_delete2 = "DELETE FROM directorios WHERE id=$carpeta[0]";
                $respuesta_delete = mysqli_query($con, $sql_delete2);
                if(count($directorios2) == 0)
                    break;
                $carpeta = $directorios2[0];
                $cont++;
            }
            $sql_delete2 = "DELETE FROM directorios WHERE id=$directorios[$i][0]";
            $respuesta_delete = mysqli_query($con, $sql_delete2);
        }else{
            $id_delete = $directorios[$i][0];
            $sql_delete = "DELETE FROM directorios WHERE id=$id_delete";
            if(mysqli_query($con, $sql_delete)){
                echo "hola mundo";
            }else{
                echo "Error deleting record: " . mysqli_error($con);
            }
        }
    }
    //var_dump($directorios);
    //$sql_delete = "DELETE FROM directorios WHERE id=$id";

    //mysqli_query($sql_delete);

    //header("Location:listarSeccion.php?r=".$id);

?>