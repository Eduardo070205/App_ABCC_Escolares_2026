<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';
require_once __DIR__ . '/../backend/models/alumno_model.php';

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

function filaAAlumno(array $f): Alumno
{
    return new Alumno(
        $f['numControl'], $f['nombre'], $f['primerAp'], $f['segundoAp'],
        $f['fechaNac'], (int)$f['semestre'], $f['carrera']
    );
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    responder(405, ['consulta' => false, 'error' => 'Método no permitido, use GET']);
}

try {
    $conexion = (new ConexionBDEscuela())->getConexion();
    $columnas = 'numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera';

    $numControl = trim($_GET['numControl'] ?? '');

    if ($numControl !== '') {
        $stmt = $conexion->prepare("SELECT $columnas FROM alumnos WHERE numControl = :nc");
        $stmt->execute([':nc' => $numControl]);
        $fila = $stmt->fetch();

        if (!$fila) {
            responder(404, ['consulta' => false, 'error' => 'No existe un alumno con ese número de control']);
        }
        responder(200, ['consulta' => true, 'alumno' => filaAAlumno($fila)]);
    }

    $filas = $conexion->query("SELECT $columnas FROM alumnos ORDER BY numControl")->fetchAll();
    $alumnos = array_map('filaAAlumno', $filas);

    responder(200, ['consulta' => true, 'total' => count($alumnos), 'alumnos' => $alumnos]);

} catch (PDOException $e) {
    responder(500, ['consulta' => false, 'error' => 'Error interno del servidor']);
}