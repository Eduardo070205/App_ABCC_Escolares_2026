<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    responder(405, ['baja' => false, 'error' => 'Método no permitido, use DELETE']);
}

// Se acepta ?numControl= en la URL o {"numControl": "..."} en el cuerpo
$numControl = trim($_GET['numControl'] ?? '');
if ($numControl === '') {
    $datos = json_decode(file_get_contents('php://input'), true);
    $numControl = is_array($datos) ? trim((string)($datos['numControl'] ?? '')) : '';
}

if ($numControl === '') {
    responder(400, ['baja' => false, 'error' => 'Falta numControl']);
}

try {
    $conexion = (new ConexionBDEscuela())->getConexion();

    $stmt = $conexion->prepare('DELETE FROM alumnos WHERE numControl = :nc');
    $stmt->execute([':nc' => $numControl]);

    if ($stmt->rowCount() === 0) {
        responder(404, ['baja' => false, 'error' => 'No existe un alumno con ese número de control']);
    }

    responder(200, ['baja' => true, 'numControl' => $numControl]);

} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // tiene registros relacionados (llave foránea)
        responder(409, ['baja' => false, 'error' => 'No se puede eliminar: el alumno tiene registros relacionados']);
    }
    responder(500, ['baja' => false, 'error' => 'Error interno del servidor']);
}