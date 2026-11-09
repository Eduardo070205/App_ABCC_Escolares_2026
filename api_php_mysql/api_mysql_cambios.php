<?php

    include_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

?>