<?php

    include_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($_SERVER["REQUEST_METHOD"] == "POST"){



        $cadenaJSON = file_get_contents("php://input");

        if(!$cadenaJSON){
            echo "No hay cadena JSON";

        }else{
            $datos = json_decode($cadenaJSON, true);
            $nc = $datos['numControl'];
            $nombre = $datos['nombre'];
            $primerAp = $datos['primerAp'];
            $segundoAp = $datos['segundoAp'];
            $fechaNac = $datos['fechaNac'];
            $semestre = $datos['semestre'];
            $carrera = $datos['carrera'];

            $sql = "UPDATE alumnos SET nombre = '$nombre', primerAp = '$primerAp', segundoAp = '$segundoAp', fechaNac = '$fechaNac', semestre = '$semestre', carrera = '$carrera' WHERE numControl = '$nc'";

            $res = mysqli_query($conexion, $sql);

            $respuesta = array();

            if($res){
                $respuesta['actualizacion'] = true;
            }else{
                $respuesta['actualizacion'] = false;
            }

            echo json_encode($respuesta);

        }

        
    }

?>