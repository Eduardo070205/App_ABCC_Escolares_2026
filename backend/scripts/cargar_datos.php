<?php
require_once __DIR__ . '/../controllers/alumno_dao.php';

header('Content-Type: application/json; charset=utf-8');

$nc = $_GET['nc'] ?? null;

if (!$nc) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el numero de control']);
    exit;
}

$alumnoDAO = new AlumnoDAO();
$datos = $alumnoDAO->consultarAlumnoNC($nc);
$alumno = $datos ? $datos : null;

if (!$alumno) {
    http_response_code(404);
    echo json_encode(['error' => 'Alumno no encontrado']);
    exit;
}

echo json_encode($alumno);

?>