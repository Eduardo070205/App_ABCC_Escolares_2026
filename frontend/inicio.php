<?php
    session_start();
    if (empty($_SESSION['usuario_autenticado'])) {
        header('Location: login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Sistema de Control Escolar</title>
</head>
<body>
    <?php require_once('menu_principal.php'); ?>

    <main class="container mt-5">
        <div class="bg-light border rounded p-5 text-center">
            <h1>Bienvenido a el Sistema de Control Escolar</h1>
            <p class="text-secondary mt-3 mb-0">Selecciona una opción del menú para comenzar.</p>
        </div>
    </main>
</body>
</html>
