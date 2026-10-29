<?php
    include("../controllers/alumno_dao.php");

    $alumnoDAO = new AlumnoDAO();

    $nc = $_POST['caja_num_control'];
    $nombre = $_POST['caja_nombre'];
    $primerApellido = $_POST['caja_primer_apellido'];
    $segundoApellido = $_POST['caja_segundo_apellido'];
    $fechaNac = $_POST['caja_fecha_nac'];
    $semestre = $_POST['caja_semestre'];
    $carrera = $_POST['caja_carrera'];

    var_dump($nc);
    var_dump($nombre);

    //Obtener los demas datos

    //VALIDACIONES

    //Crear OBJETO del alumno

    //Invoacion de los metodos

    $res = $alumnoDAO->actualizarAlumno($nc, $nombre, $primerApellido, $segundoApellido, $fechaNac, $semestre, $carrera);

    if($res){

        //echo "Ya casi soy ingeniero";
        //header('location:../../frontend/menu_principal.php');
        header('location: ../../frontend/bajas_cambios.php');

    }else{

        echo "Me dedico a redes";

        

    }


?>