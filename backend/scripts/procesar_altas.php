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


    

    //Obtener los demas datos

    //VALIDACIONES
    /*Suponiendo que el Número de Control debe ser numerico (cadena con numeros)
        
        - Que exista la variable relacionada al dato
        - No vacíos
        - Solo números

    */

    session_start();

    // Limpiar avisos anteriores antes de validar el nuevo envio.
    unset(
        $_SESSION['error_nc'],
        $_SESSION['error_nombre'],
        $_SESSION['error_primer_apellido'],
        $_SESSION['error_segundo_apellido']
    );

    $nc_correcto = false;
    $nombre_correcto = false;
    $primerApellido_correcto = false;
    $segundoApellido_correcto = false;
    

    if(isset($nc) && !empty($nc) && is_numeric($nc)){

        $nc_correcto = true;

    }else{

        $_SESSION['error_nc'] = true;

    }
    
    if(isset($nombre) && !empty($nombre) && ctype_alpha($nombre)){

        $nombre_correcto = true;

    }else{

        $_SESSION['error_nombre'] = true;

    }

    if(isset($primerApellido) && !empty($primerApellido) && ctype_alpha($primerApellido)){

        $primerApellido_correcto = true;

    }else{

        $_SESSION['error_primer_apellido'] = true;

    }

    if(isset($segundoApellido) && !empty($segundoApellido) && ctype_alpha($segundoApellido)){

        $segundoApellido_correcto = true;

    }else{

        $_SESSION['error_segundo_apellido'] = true;

    }



    //Un nombre DEBE ser ALFABETICO





    //Crear OBJETO del alumno



    if($nc_correcto && $nombre_correcto && $primerApellido_correcto && $segundoApellido_correcto){
    
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

        //else de fallo de validaciones

        $_SESSION['nc'] = $nc;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['primerApellido'] = $primerApellido;
        $_SESSION['segundoApellido'] = $segundoApellido;
        $_SESSION['fechaNac'] = $fechaNac;
        $_SESSION['semestre'] = $semestre;
        $_SESSION['carrera'] = $carrera;
        header('location: ../../frontend/fromulario_altas.php');

    }

    //Invoacion de los metodos

    

?>
