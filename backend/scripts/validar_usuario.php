<?php

    $user = $_POST['caja_usuario'];
    $pass = $_POST['caja_password'];

    $user_cifrado = sha1($user);
    $pass_cifrada = sha1($pass);

    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($conexion){

        $sql = "SELECT usuario FROM usuarios WHERE usuario = ? AND password = ?";

        $res = $conexion->prepare($sql);
        $res->execute([$user_cifrado, $pass_cifrada]);

        if($res->fetch() !== false){

            session_start();
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['nombre_usuario'] = $user;
            header("Location: ../../frontend/inicio.php");

        }else{

            echo "No encontrado";

        }

    }


?>
