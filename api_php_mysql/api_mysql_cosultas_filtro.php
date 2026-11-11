<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(['error' => 'Utiliza el metodo POST.']);
    exit;
}

// Ejemplo: {"nombre":"Ana", "semestre":3}. Un objeto {} consulta todos.
$datos = json_decode(file_get_contents('php://input'));
if (json_last_error() !== JSON_ERROR_NONE || !is_object($datos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Envia un objeto JSON valido.']);
    exit;
}

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
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require_once __DIR__ . '/../backend/config/database/conexion_mysql_escuela.php';
    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();
    mysqli_set_charset($conexion, 'utf8mb4');

    $sql = 'SELECT numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera FROM alumnos';
    if ($condiciones) {
        $sql .= ' WHERE ' . implode(' AND ', $condiciones);
    }
    $sql .= ' ORDER BY numControl';

    $consulta = mysqli_prepare($conexion, $sql);
    if ($valores) {
        mysqli_stmt_bind_param($consulta, str_repeat('s', count($valores)), ...$valores);
    }
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);
    $alumnos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $alumnos[] = $fila;
    }
    mysqli_free_result($resultado);
    mysqli_stmt_close($consulta);
    mysqli_close($conexion);

    echo json_encode([
        'alumnos' => $alumnos,
        'consulta' => $alumnos ? 'Consulta exitosa' : 'No hay registros'
    ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
} catch (mysqli_sql_exception $error) {
    error_log('Error en consulta de alumnos: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo realizar la consulta.']);
}
