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

function buscarAlumno(PDO $con, string $numControl): ?Alumno
{
    $stmt = $con->prepare(
        'SELECT numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera
           FROM alumnos WHERE numControl = :nc'
    );
    $stmt->execute([':nc' => $numControl]);
    $f = $stmt->fetch();

    if (!$f) {
        return null;
    }
    return new Alumno(
        $f['numControl'], $f['nombre'], $f['primerAp'], $f['segundoAp'],
        $f['fechaNac'], (int)$f['semestre'], $f['carrera']
    );
}

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== 'PUT' && $metodo !== 'PATCH') {
    header('Allow: PUT, PATCH');
    responder(405, ['cambio' => false, 'error' => 'Método no permitido, use PUT o PATCH']);
}

$numControl = trim($_GET['numControl'] ?? '');
if ($numControl === '') {
    responder(400, ['cambio' => false, 'error' => 'Falta numControl en la URL (?numControl=...)']);
}

$datos = json_decode(file_get_contents('php://input'), true);
if (!is_array($datos)) {
    responder(400, ['cambio' => false, 'error' => 'Se esperaba un JSON válido']);
}

// campo del JSON => setter del modelo
$setters = [
    'nombre'    => 'setNombre',
    'primerAp'  => 'setPrimerAp',
    'segundoAp' => 'setSegundoAp',
    'fechaNac'  => 'setFechaNac',
    'semestre'  => 'setSemestre',
    'carrera'   => 'setCarrera',
];

if ($metodo === 'PUT') {
    $faltan = array_values(array_diff(array_keys($setters), array_keys($datos)));
    if ($faltan) {
        responder(400, ['cambio' => false, 'error' => 'PUT requiere todos los campos', 'faltan' => $faltan]);
    }
}

$enviados = array_intersect_key($datos, $setters);
if (!$enviados) {
    responder(400, ['cambio' => false, 'error' => 'No se envió ningún campo válido para modificar']);
}

foreach ($enviados as $valor) {
    if (!is_scalar($valor) && $valor !== null) {
        responder(400, ['cambio' => false, 'error' => 'Los valores deben ser texto o número']);
    }
}

try {
    $conexion = (new ConexionBDEscuela())->getConexion();

    $alumno = buscarAlumno($conexion, $numControl);
    if ($alumno === null) {
        responder(404, ['cambio' => false, 'error' => 'No existe un alumno con ese número de control']);
    }

    foreach ($enviados as $campo => $valor) {
        $valor = ($campo === 'semestre') ? (int)$valor : trim((string)$valor);
        $alumno->{$setters[$campo]}($valor);
    }

    if ($alumno->getNombre() === '' || $alumno->getPrimerAp() === ''
        || $alumno->getFechaNac() === '' || $alumno->getSemestre() <= 0 || $alumno->getCarrera() === '') {
        responder(400, ['cambio' => false, 'error' => 'Hay campos obligatorios vacíos o inválidos']);
    }

    $stmt = $conexion->prepare(
        'UPDATE alumnos
            SET nombre = :nombre, primerAp = :primerAp, segundoAp = :segundoAp,
                fechaNac = :fechaNac, semestre = :semestre, carrera = :carrera
          WHERE numControl = :numControl'
    );
    $stmt->execute([
        ':nombre'     => $alumno->getNombre(),
        ':primerAp'   => $alumno->getPrimerAp(),
        ':segundoAp'  => $alumno->getSegundoAp(),
        ':fechaNac'   => $alumno->getFechaNac(),
        ':semestre'   => $alumno->getSemestre(),
        ':carrera'    => $alumno->getCarrera(),
        ':numControl' => $alumno->getNumControl(),
    ]);

    responder(200, ['cambio' => true, 'alumno' => $alumno]);

} catch (PDOException $e) {
    responder(500, ['cambio' => false, 'error' => 'Error interno del servidor']);
}