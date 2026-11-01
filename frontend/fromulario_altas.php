<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Registro</title>
</head>

<body>

    <?php require_once('menu_principal.php'); ?>

    <div class="container mt-4">
        <!-- Alerta con corrección en estilo 'display: block' -->
        <div id="alerta-exito" class="alert alert-success alert-dismissible fade show" role="alert" 
            style="display: <?php echo isset($_SESSION['inserccion_correcta']) ? 'block' : 'none'; ?>;">
            Alumno agregado con éxito.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <form action="../backend/scripts/procesar_altas.php" method="POST">
            
            <!-- Número de Control -->
            <div class="mb-3 col-md-6">
                <label for="caja_num_control" class="form-label">Número de Control</label>
                <input type="text" class="form-control" id="caja_num_control" 
                       name="caja_num_control" placeholder="Número de Control"
                       value="<?php echo isset($_SESSION['nc']) ? $_SESSION['nc'] : ''; ?>" required>
                <?php if (isset($_SESSION['error_nc'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar sólo números</div>
                <?php endif; ?>
            </div>

            <!-- Nombre -->
            <div class="mb-3">
                <label for="caja_nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" 
                       placeholder="Nombre" required value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>" required>
                <?php if (isset($_SESSION['error_nombre'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar sólo letras</div>
                <?php endif; ?>
            </div>

            <!-- Apellidos -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="caja_primer_apellido" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="caja_primer_apellido"
                           name="caja_primer_apellido" placeholder="Primer Apellido" required
                           value="<?php echo isset($_SESSION['primerApellido']) ? $_SESSION['primerApellido'] : ''; ?>" required>
                <?php if (isset($_SESSION['error_primer_apellido'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar sólo letras</div>
                <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="caja_segundo_apellido" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="caja_segundo_apellido" 
                           name="caja_segundo_apellido" placeholder="Segundo Apellido"
                           value="<?php echo isset($_SESSION['segundoApellido']) ? $_SESSION['segundoApellido'] : ''; ?>" required>
                    <?php if (isset($_SESSION['error_segundo_apellido'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar sólo letras</div>
                    <?php endif; ?>
                
                </div>
            </div>

            <!-- 1. Fecha de Nacimiento (Compatible con MySQL DATE) -->
            <div class="mb-3">
                <label for="caja_fecha_nac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="caja_fecha_nac" 
                       name="caja_fecha_nac" value="<?php echo htmlspecialchars($_SESSION['fechaNac'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required >
            </div>

            <!-- 2. Semestre (Convertido a <select> de Bootstrap 5) -->
            <div class="mb-3">
                <label for="caja_semestre" class="form-label">Semestre</label>
                <select class="form-select" id="caja_semestre" name="caja_semestre" required>
                    <option value="" <?php echo empty($_SESSION['semestre']) ? 'selected' : ''; ?> disabled>Selecciona el Semestre...</option>
                    <option value="1" <?php echo (string) ($_SESSION['semestre'] ?? '') === '1' ? 'selected' : ''; ?>>Semestre 1</option>
                    <option value="2" <?php echo (string) ($_SESSION['semestre'] ?? '') === '2' ? 'selected' : ''; ?>>Semestre 2</option>
                    <option value="3" <?php echo (string) ($_SESSION['semestre'] ?? '') === '3' ? 'selected' : ''; ?>>Semestre 3</option>
                    <option value="4" <?php echo (string) ($_SESSION['semestre'] ?? '') === '4' ? 'selected' : ''; ?>>Semestre 4</option>
                    <option value="5" <?php echo (string) ($_SESSION['semestre'] ?? '') === '5' ? 'selected' : ''; ?>>Semestre 5</option>
                    <option value="6" <?php echo (string) ($_SESSION['semestre'] ?? '') === '6' ? 'selected' : ''; ?>>Semestre 6</option>
                    <option value="7" <?php echo (string) ($_SESSION['semestre'] ?? '') === '7' ? 'selected' : ''; ?>>Semestre 7</option>
                    <option value="8" <?php echo (string) ($_SESSION['semestre'] ?? '') === '8' ? 'selected' : ''; ?>>Semestre 8</option>
                    <option value="9" <?php echo (string) ($_SESSION['semestre'] ?? '') === '9' ? 'selected' : ''; ?>>Semestre 9</option>
                    <option value="10" <?php echo (string) ($_SESSION['semestre'] ?? '') === '10' ? 'selected' : ''; ?>>Semestre 10</option>
                </select>
            </div>

            <!-- 3. Carrera (Convertido a <select> de Bootstrap 5) -->
            <div class="mb-3">
                <label for="caja_carrera" class="form-label">Carrera</label>
                <select class="form-select" id="caja_carrera" name="caja_carrera" required>
                    <option value="" <?php echo empty($_SESSION['carrera']) ? 'selected' : ''; ?> disabled>Selecciona la Carrera...</option>
                    <option value="ISC" <?php echo ($_SESSION['carrera'] ?? '') === 'ISC' ? 'selected' : ''; ?>>Ingeniería en Sistemas Computacionales</option>
                    <option value="IM" <?php echo ($_SESSION['carrera'] ?? '') === 'IM' ? 'selected' : ''; ?>>Ingeniería Mecatrónica</option>
                    <option value="IIA" <?php echo ($_SESSION['carrera'] ?? '') === 'IIA' ? 'selected' : ''; ?>>Ingeniería en Industrias Alimentarias</option>
                    <option value="CP" <?php echo ($_SESSION['carrera'] ?? '') === 'CP' ? 'selected' : ''; ?>>Contador Público</option>
                    <option value="LA" <?php echo ($_SESSION['carrera'] ?? '') === 'LA' ? 'selected' : ''; ?>>Licenciatura en Administración</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Enviar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerta = document.getElementById('alerta-exito');
            
            // Verifica si la alerta existe y está visible
            if (alerta && alerta.style.display !== 'none') {
                setTimeout(function() {
                    // Usa la API de Bootstrap para cerrar la alerta con transición suave
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alerta);
                    bsAlert.close();
                }, 5000); // 5000ms = 5 segundos
            }
        });
    </script>
</body>

</body>
</html>

<?php 
    unset($_SESSION['inserccion_correcta']);
    unset($_SESSION['nc']);
    unset($_SESSION['nombre']);
    unset($_SESSION['primerApellido']);
    unset($_SESSION['segundoApellido']);
    unset($_SESSION['fechaNac']);
    unset($_SESSION['semestre']);
    unset($_SESSION['carrera']);
?>
