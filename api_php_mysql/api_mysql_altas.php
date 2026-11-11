<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';
require_once __DIR__ . '/../backend/models/alumno_model.php'; // ajusta la ruta a donde tengas tu modelo

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    responder(405, ['alta' => false, 'error' => 'Método no permitido, use POST']);
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!is_array($datos)) {
    responder(400, ['alta' => false, 'error' => 'Se esperaba un JSON válido']);
}

$alumno = new Alumno(
    trim($datos['numControl'] ?? ''),
    trim($datos['nombre'] ?? ''),
    trim($datos['primerAp'] ?? ''),
    trim($datos['segundoAp'] ?? ''),
    trim($datos['fechaNac'] ?? ''),
    (int)($datos['semestre'] ?? 0),
    trim($datos['carrera'] ?? '')
);

if ($alumno->getNumControl() === '' || $alumno->getNombre() === '' || $alumno->getPrimerAp() === ''
    || $alumno->getFechaNac() === '' || $alumno->getSemestre() <= 0 || $alumno->getCarrera() === '') {
    responder(400, ['alta' => false, 'error' => 'Faltan campos obligatorios']);
}

try {
    $conexion = (new ConexionBDEscuela())->getConexion();

    $sql = "INSERT INTO alumnos
                (numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera)
            VALUES
                (:numControl, :nombre, :primerAp, :segundoAp, :fechaNac, :semestre, :carrera)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':numControl' => $alumno->getNumControl(),
        ':nombre'     => $alumno->getNombre(),
        ':primerAp'   => $alumno->getPrimerAp(),
        ':segundoAp'  => $alumno->getSegundoAp(),
        ':fechaNac'   => $alumno->getFechaNac(),
        ':semestre'   => $alumno->getSemestre(),
        ':carrera'    => $alumno->getCarrera(),
    ]);

    responder(201, ['alta' => true, 'numControl' => $alumno->getNumControl()]);

} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // llave duplicada
        responder(409, ['alta' => false, 'error' => 'Ya existe un alumno con ese número de control']);
    }
    responder(500, ['alta' => false, 'error' => 'Error interno del servidor']);
}