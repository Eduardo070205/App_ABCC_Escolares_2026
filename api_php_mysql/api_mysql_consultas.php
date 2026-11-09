<?php

    include_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $cadenaJSON = file_get_contents("php://input");

        if(!$cadenaJSON){
            echo "No hay cadena JSON";

        }else{

            $sql = "SELECT * FROM alumnos";

            $res = mysqli_query($conexion, $sql);

            $respuesta['alumnos'] = array();

            if($res){
                while($fila = mysqli_fetch_assoc($res)){
                    $alumno = array();
                    $alumno['numControl'] = $fila['numControl'];
                    $alumno['nombre'] = $fila['nombre'];    
                    $alumno['primerAp'] = $fila['primerAp'];
                    $alumno['segundoAp'] = $fila['segundoAp'];
                    $alumno['fechaNac'] = $fila['fechaNac'];
                    $alumno['semestre'] = $fila['semestre'];
                    $alumno['carrera'] = $fila['carrera'];
                    array_push($respuesta['alumnos'], $alumno);
                }
                $respuesta['consulta'] = "Consulta exitosa";
            }else{
                $respuesta['consulta'] = "No hay registros";
            }

            echo json_encode($respuesta);

        }

        
    }

?>