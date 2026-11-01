<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>

    <?php  require_once('menu_principal.php');?>

        <?php
        //var_dump($_GET['nc']);

        $nc = $_GET['nc'];

        include_once("../backend/controllers/alumno_dao.php");
        $alumnoDAO = new AlumnoDAO();

        $datos = $alumnoDAO->consultarAlumnoNC($nc);

        $usuario = $datos->fetch_assoc();
        if (isset($_SESSION['nc']) && (string) $_SESSION['nc'] === (string) $nc) {
            $usuario['numControl'] = $_SESSION['nc'];
            $usuario['nombre'] = $_SESSION['nombre'];
            $usuario['primerAp'] = $_SESSION['primerApellido'];
            $usuario['segundoAp'] = $_SESSION['segundoApellido'];
            $usuario['fechaNac'] = $_SESSION['fechaNac'];
            $usuario['semestre'] = $_SESSION['semestre'];
            $usuario['carrera'] = $_SESSION['carrera'];
        }



    ?>



    <div class="container">
        <?php if (!empty($_SESSION['actualizacion_correcta'])): ?>
            <div class="alert alert-success">Cambios guardados correctamente.</div>
        <?php endif; ?>
        <form action="../backend/scripts/procesar_cambios.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="caja_num_control">Numero de Control</label>
                    <input type="text" class="form-control" id="caja_num_control" name="caja_num_control" placeholder="Numero de Control" value="<?php echo htmlspecialchars($usuario['numControl']); ?>" readonly required>
                    <?php if (isset($_SESSION['error_nc'])): ?>
                        <div class="text-danger small mt-1">*Debes ingresar solo numeros</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="caja_nombre">Nombre</label>
                    <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    <?php if (isset($_SESSION['error_nombre'])): ?>
                        <div class="text-danger small mt-1">*Debes ingresar solo letras</div>
                    <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="caja_primer_apellido">Primer Apellido</label>
                    <input type="text" class="form-control" id="caja_primer_apellido" name="caja_primer_apellido" placeholder="Primer Apellido" value="<?php echo htmlspecialchars($usuario['primerAp']); ?>" required>
                    <?php if (isset($_SESSION['error_primer_apellido'])): ?>
                        <div class="text-danger small mt-1">*Debes ingresar solo letras</div>
                    <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="caja_segundo_apellido">Segundo Apellido</label>
                    <input type="text" class="form-control" id="caja_segundo_apellido" name="caja_segundo_apellido" placeholder="" value="<?php echo htmlspecialchars($usuario['segundoAp']); ?>" required>
                    <?php if (isset($_SESSION['error_segundo_apellido'])): ?>
                        <div class="text-danger small mt-1">*Debes ingresar solo letras</div>
                    <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="caja_fecha_nac">Fecha de Nacimiento</label>
                <input type="text" class="form-control" id="caja_fecha_nac" name="caja_fecha_nac" placeholder="" value="<?php echo htmlspecialchars($usuario['fechaNac']); ?>">
            </div>
            <div class="form-group">
                <label for="caja_semestre">Semestre</label>
                <input type="text" class="form-control" id="caja_semestre" name="caja_semestre" placeholder="" value="<?php echo htmlspecialchars($usuario['semestre']); ?>">
            </div>
            <div class="form-group">
                <label for="caja_carrera">Carrera</label>
                <input type="text" class="form-control" id="caja_carrera" name="caja_carrera" placeholder="" value="<?php echo htmlspecialchars($usuario['carrera']); ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>

    </div>


</body>

</html>

<?php
    unset(
        $_SESSION['actualizacion_correcta'],
        $_SESSION['nc'], $_SESSION['nombre'],
        $_SESSION['primerApellido'], $_SESSION['segundoApellido'],
        $_SESSION['fechaNac'], $_SESSION['semestre'], $_SESSION['carrera']
    );
?>
