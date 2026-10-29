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



    ?>



    <div class="container">
        <form action="../backend/scripts/procesar_cambios.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="caja_num_control">Numero de Control</label>
                    <input type="text" class="form-control" id="caja_num_control" name="caja_num_control" placeholder="Numero de Control" value="<?php echo htmlspecialchars($usuario['numControl']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="caja_nombre">Nombre</label>
                <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
            </div>
            <div class="form-group">
                <label for="caja_primer_apellido">Primer Apellido</label>
                <input type="text" class="form-control" id="caja_primer_apellido" name="caja_primer_apellido" placeholder="Primer Apellido" value="<?php echo htmlspecialchars($usuario['primerAp']); ?>">
            </div>
            <div class="form-group">
                <label for="caja_segundo_apellido">Segundo Apellido</label>
                <input type="text" class="form-control" id="caja_segundo_apellido" name="caja_segundo_apellido" placeholder="" value="<?php echo htmlspecialchars($usuario['segundoAp']); ?>">
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