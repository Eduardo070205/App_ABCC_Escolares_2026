<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Búsqueda de alumnos</title>
</head>
<body>
<?php
    require_once('menu_principal.php');
    if (empty($_SESSION['usuario_autenticado'])) {
        exit;
    }
    require_once __DIR__ . '/../backend/controllers/alumno_dao.php';

    $criterios = [
        'control' => 'Número de control', 'nombre' => 'Nombre',
        'apellido1' => 'Primer apellido', 'apellido2' => 'Segundo apellido',
        'anio' => 'Año de nacimiento', 'semestre' => 'Semestre', 'carrera' => 'Carrera'
    ];
    $carreras = [
        'ISC' => 'Ingeniería en Sistemas Computacionales',
        'IM' => 'Ingeniería Mecatrónica',
        'IIA' => 'Ingeniería en Industrias Alimentarias',
        'CP' => 'Contador Público',
        'LA' => 'Licenciatura en Administración'
    ];
    $criterio = isset($_GET['criterio']) && is_string($_GET['criterio']) ? $_GET['criterio'] : '';
    $texto = isset($_GET['valor']) && is_string($_GET['valor']) ? trim($_GET['valor']) : '';
    $anio = isset($_GET['anio']) && is_string($_GET['anio']) ? $_GET['anio'] : '';
    $semestre = isset($_GET['semestre']) && is_string($_GET['semestre']) ? $_GET['semestre'] : '';
    $carrera = isset($_GET['carrera']) && is_string($_GET['carrera']) ? $_GET['carrera'] : '';
    $error = '';
    $datos = false;

    if (isset($_GET['buscar'])) {
        $valor = $texto;
        if ($criterio === 'anio') {
            $valor = $anio;
        } elseif ($criterio === 'semestre') {
            $valor = $semestre;
        } elseif ($criterio === 'carrera') {
            $valor = $carrera;
        }

        if (!isset($criterios[$criterio])) {
            $error = 'Selecciona un criterio de búsqueda.';
        } elseif ($valor === '') {
            $error = 'Ingresa o selecciona el dato que corresponde al criterio.';
        } elseif ($criterio === 'control' && !ctype_digit($valor)) {
            $error = 'El número de control debe contener solo números.';
        } elseif ($criterio === 'anio' && (!ctype_digit($valor) || $valor < 1900 || $valor > date('Y'))) {
            $error = 'Selecciona un año válido.';
        } elseif ($criterio === 'semestre' && !in_array($valor, array_map('strval', range(1, 10)), true)) {
            $error = 'Selecciona un semestre válido.';
        } elseif ($criterio === 'carrera' && !isset($carreras[$valor])) {
            $error = 'Selecciona una carrera válida.';
        } else {
            $alumnoDAO = new AlumnoDAO();
            $datos = $alumnoDAO->consultarAlumnosBusqueda($criterio, $valor);
            if (!$datos) {
                $error = 'No se pudo realizar la búsqueda.';
            }
        }
    }
?>
    <main class="container mt-4">
        <h3>Búsqueda de alumnos</h3>
        <form action="buqueda_alumnos.php" method="GET">
            <div class="mb-3">
                <label for="criterio" class="form-label">Buscar por</label>
                <select id="criterio" name="criterio" class="form-select" required>
                    <option value="">Selecciona una opción...</option>
                    <?php foreach ($criterios as $clave => $etiqueta): ?>
                        <option value="<?php echo $clave; ?>" <?php echo $criterio === $clave ? 'selected' : ''; ?>><?php echo $etiqueta; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p class="text-body-secondary">Completa el campo que corresponde al criterio seleccionado.</p>
            <div class="mb-3" id="campo-texto">
                <label for="valor" class="form-label">Número de control, nombre o apellido</label>
                <input type="text" id="valor" name="valor" class="form-control"
                    value="<?php echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="mb-3" id="campo-anio">
                <label for="anio" class="form-label">Año de nacimiento</label>
                <select id="anio" name="anio" class="form-select">
                    <option value="">Selecciona un año...</option>
                    <?php for ($i = (int) date('Y'); $i >= 1900; $i--): ?>
                        <option value="<?php echo $i; ?>" <?php echo $anio === (string) $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3" id="campo-semestre">
                <label for="semestre" class="form-label">Semestre</label>
                <select id="semestre" name="semestre" class="form-select">
                    <option value="">Selecciona un semestre...</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $semestre === (string) $i ? 'selected' : ''; ?>>Semestre <?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3" id="campo-carrera">
                <label for="carrera" class="form-label">Carrera</label>
                <select id="carrera" name="carrera" class="form-select">
                    <option value="">Selecciona una carrera...</option>
                    <?php foreach ($carreras as $clave => $etiqueta): ?>
                        <option value="<?php echo $clave; ?>" <?php echo $carrera === $clave ? 'selected' : ''; ?>><?php echo $etiqueta; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="buscar" value="1" class="btn btn-primary">Buscar</button>
            <a href="buqueda_alumnos.php" class="btn btn-secondary">Limpiar</a>
        </form>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php elseif ($datos): ?>
            <p class="mt-3"><?php echo mysqli_num_rows($datos); ?> registro(s) encontrado(s).</p>
            <?php if (mysqli_num_rows($datos) === 0): ?>
                <p>No se encontraron alumnos con ese criterio.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Número de control</th><th>Nombre</th><th>Primer apellido</th>
                                <th>Segundo apellido</th><th>Fecha de nacimiento</th><th>Semestre</th><th>Carrera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = mysqli_fetch_assoc($datos)): ?>
                                <tr>
                                    <?php foreach (['numControl', 'nombre', 'primerAp', 'segundoAp', 'fechaNac', 'semestre'] as $campo): ?>
                                        <td><?php echo htmlspecialchars((string) $fila[$campo], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php endforeach; ?>
                                    <td><?php echo htmlspecialchars($carreras[$fila['carrera']] ?? $fila['carrera'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <script>
        const criterio = document.getElementById('criterio');
        const campos = {
            texto: document.getElementById('campo-texto'),
            anio: document.getElementById('campo-anio'),
            semestre: document.getElementById('campo-semestre'),
            carrera: document.getElementById('campo-carrera')
        };

        function mostrarCampo() {
            const opcion = criterio.value;
            const esTexto = ['control', 'nombre', 'apellido1', 'apellido2'].includes(opcion);
            const activo = esTexto ? 'texto' : opcion;

            Object.entries(campos).forEach(([nombre, contenedor]) => {
                const visible = nombre === activo;
                contenedor.hidden = !visible;
                const entrada = contenedor.querySelector('input, select');
                entrada.disabled = !visible;
                entrada.required = visible;
            });

            if (esTexto) {
                campos.texto.querySelector('label').textContent =
                    criterio.options[criterio.selectedIndex].textContent;
            }
        }

        criterio.addEventListener('change', mostrarCampo);
        mostrarCampo();
    </script>
</body>
</html>
