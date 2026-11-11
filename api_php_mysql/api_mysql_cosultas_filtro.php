<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(['error' => 'Utiliza el metodo GET.']);
    exit;
}

// Ejemplo: ?nombre=Ana&semestre=3. Sin filtros consulta todos.
$datos = $_GET;

$campos = ['numControl', 'nombre', 'primerAp', 'segundoAp', 'fechaNac', 'semestre', 'carrera'];
$parciales = ['numControl', 'nombre', 'primerAp', 'segundoAp'];
$condiciones = [];
$valores = [];

foreach ($datos as $campo => $valor) {
    if (!in_array($campo, $campos, true)) {
        http_response_code(400);
        echo json_encode(['error' => 'Filtro desconocido: ' . $campo]);
        exit;
    }
    if ($valor === null) {
        continue;
    }
    if (!is_string($valor) && !is_int($valor)) {
        http_response_code(400);
        echo json_encode(['error' => 'El filtro ' . $campo . ' debe ser texto o un entero.']);
        exit;
    }
    $valor = trim((string) $valor);
    if ($valor === '') {
        continue;
    }

    // Solo se usan columnas permitidas; los valores se envian por separado.
    // LOCATE busca texto literal, incluyendo caracteres como % y _.
    $condiciones[] = in_array($campo, $parciales, true)
        ? "LOCATE(?, `$campo`) > 0"
        : "`$campo` = ?";
    $valores[] = $valor;
}

try {

    require_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';
    require_once __DIR__ . '/../backend/models/alumno_model.php';
    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();


    $sql = 'SELECT numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera FROM alumnos';
    if ($condiciones) {
        $sql .= ' WHERE ' . implode(' AND ', $condiciones);
    }
    $sql .= ' ORDER BY numControl';

    $consulta = $conexion->prepare($sql);
    $consulta->execute($valores);
    $alumnos = [];
    while ($fila = $consulta->fetch()) {
        $alumnos[] = new Alumno(
            $fila['numControl'], $fila['nombre'], $fila['primerAp'], $fila['segundoAp'],
            $fila['fechaNac'], (int) $fila['semestre'], $fila['carrera']
        );
    }

    echo json_encode([
        'alumnos' => $alumnos,
        'consulta' => $alumnos ? 'Consulta exitosa' : 'No hay registros'
    ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
} catch (PDOException $error) {
    error_log('Error en consulta de alumnos: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo realizar la consulta.']);
}
