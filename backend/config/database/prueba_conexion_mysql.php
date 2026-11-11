<?php

    header('Content-Type: text/plain; charset=utf-8');

    // Solo para pruebas: muestra errores en pantalla
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include_once __DIR__ . '/conexion_mysql_escuela.php';

    try {
        $conexion = new ConexionBDEscuela();
        $con = $conexion->getConexion();

        echo "Conexión exitosa\n";

        // Confirma que realmente responde la base
        $version = $con->query('SELECT VERSION()')->fetchColumn();
        echo "Versión de MySQL: $version\n";

        // Confirma que existe la tabla y hay acceso a ella
        $total = $con->query('SELECT COUNT(*) FROM alumnos')->fetchColumn();
        echo "Registros en alumnos: $total\n";

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage() . "\n";
    }

?>