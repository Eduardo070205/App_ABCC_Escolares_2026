<?php
    session_start();

    if (!empty($_SESSION['usuario_autenticado'])) {
        header('Location: frontend/inicio.php');
    } else {
        header('Location: frontend/login.php');
    }
    exit;
