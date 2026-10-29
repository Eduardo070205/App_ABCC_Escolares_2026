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
        <div class="alert alert-success alert-dismissible fade show" role="alert" 
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
                <?php if (isset($_SESSION['nc'])): ?>
                    <div class="text-danger small mt-1">*Debes ingresar sólo números</div>
                <?php endif; ?>
            </div>

            <!-- Nombre -->
            <div class="mb-3">
                <label for="caja_nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" 
                       placeholder="Nombre" required>
            </div>

            <!-- Apellidos -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="caja_primer_apellido" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="caja_primer_apellido"
                           name="caja_primer_apellido" placeholder="Primer Apellido" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="caja_segundo_apellido" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="caja_segundo_apellido" 
                           name="caja_segundo_apellido" placeholder="Segundo Apellido">
                </div>
            </div>

            <!-- 1. Fecha de Nacimiento (Compatible con MySQL DATE) -->
            <div class="mb-3">
                <label for="caja_fecha_nac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="caja_fecha_nac" 
                       name="caja_fecha_nac" required>
            </div>

            <!-- 2. Semestre (Convertido a <select> de Bootstrap 5) -->
            <div class="mb-3">
                <label for="caja_semestre" class="form-label">Semestre</label>
                <select class="form-select" id="caja_semestre" name="caja_semestre" required>
                    <option value="" selected disabled>Selecciona el Semestre...</option>
                    <option value="1">Semestre 1</option>
                    <option value="2">Semestre 2</option>
                    <option value="3">Semestre 3</option>
                    <option value="4">Semestre 4</option>
                    <option value="5">Semestre 5</option>
                    <option value="6">Semestre 6</option>
                    <option value="7">Semestre 7</option>
                    <option value="8">Semestre 8</option>
                    <option value="9">Semestre 9</option>
                    <option value="10">Semestre 10</option>
                </select>
            </div>

            <!-- 3. Carrera (Convertido a <select> de Bootstrap 5) -->
            <div class="mb-3">
                <label for="caja_carrera" class="form-label">Carrera</label>
                <select class="form-select" id="caja_carrera" name="caja_carrera" required>
                    <option value="" selected disabled>Selecciona la Carrera...</option>
                    <option value="ISC">Ingeniería en Sistemas Computacionales</option>
                    <option value="IM">Ingeniería Mecatrónica</option>
                    <option value="IIA">Ingeniería en Industrias Alimentarias</option>
                    <option value="CP">Contador Público</option>
                    <option value="LA">Licenciatura en Administración</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Enviar</button>
        </form>
    </div>

</body>
</html>

<?php 
    unset($_SESSION['inserccion_correcta']);
    unset($_SESSION['nc']);
?>