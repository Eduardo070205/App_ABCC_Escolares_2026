<?php

    require_once __DIR__ . '/../controllers/usuario_dao.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../../frontend/registrar_usuario.php');
        exit();
    }

    $user = $_POST['caja_usuario'] ?? '';
    $pass = $_POST['caja_password'] ?? '';
    $confirmPass = $_POST['caja_confirmar_password'] ?? '';

    $user_correcto = false;
    $pass_correcto = false;

    //VALIDACIONES
    session_start();
    unset($_SESSION['error_vacios'], $_SESSION['error_pass'], $_SESSION['error_existente'], $_SESSION['exito']);
    // Conservar los datos antes de cualquier redireccion por error.
    $_SESSION['user'] = $user;
    $_SESSION['pass'] = $pass;
    $_SESSION['confirmPass'] = $confirmPass;
    if(empty($user) || empty($pass) || empty($confirmPass)){
        $_SESSION['error_vacios'] = true;
        header("Location: ../../frontend/registrar_usuario.php");
        exit();
    }else{
        $_SESSION['error_vacios'] = false;
        $user_correcto = true;
    }

    if($pass == $confirmPass){

        $_SESSION['error_pass'] = false;
        $pass_correcto = true;
    
    }else{
        $_SESSION['error_pass'] = true;
        header("Location: ../../frontend/registrar_usuario.php");
        exit();
    }



    if($user_correcto && $pass_correcto){
        $usuarioDAO = new UsuarioDAO();
        $usuario = new Usuario($user, $pass);
        $res = $usuarioDAO->agregarUsuario($usuario);
        if($res){
            unset($_SESSION['user'], $_SESSION['pass'], $_SESSION['confirmPass']);
            $_SESSION['exito'] = true;
            header("Location: ../../frontend/registrar_usuario.php");
            exit();
        }else{
            $_SESSION['error_existente'] = true;
            header("Location: ../../frontend/registrar_usuario.php");
            exit();
        }
    }else{

        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $_SESSION['confirmPass'] = $confirmPass;
        header("Location: ../../frontend/registrar_usuario.php");
        exit();
    }


?>
