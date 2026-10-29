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
    /*Suponiendo que el Número de Control debe ser numerico (cadena con numeros)
        
        - Que exista la variable relacionada al dato
        - No vacíos
        - Solo números

    */

    session_start();

    $nc_correcto = false;
    
    if(isset($nc) && !empty($nc) && is_numeric($nc)){

        $nc_correcto = true;

    }else{

        $_SESSION['error_nc'] = true;

    }




    //Un nombre DEBE ser ALFABETICO





    //Crear OBJETO del alumno



    if($nc_correcto){
    
        $res = $alumnoDAO->agregarAlumno($nc, $nombre, $primerApellido, $segundoApellido, $fechaNac, $semestre, $carrera);

        if($res){

            //echo "Ya casi soy ingeniero";
            //header('location:../../frontend/menu_principal.php');
            $_SESSION['inserccion_correcta'] = true;
            header('location: ../../frontend/fromulario_altas.php');

        }else{

            $_SESSION['inserccion_correcta'] = false;
            
        

        }

    }else{

        //else de falllo de validaciones

        $_SESSION['nc'] = $nc;
        header('location: ../../frontend/fromulario_altas.php');

    }

    //Invoacion de los metodos

    

?>