<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Regstros</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

  <?php require_once('menu_principal.php'); ?>

  <div class="container">

    <h3>Listado de Alumnos</h3>

  </div>



<?php 

    require_once __DIR__ . '/../backend/controllers/alumno_dao.php';

    $alumnoDAO = new AlumnoDAO();
    $datos = $alumnoDAO->consultarAlumno();

    if (!$datos || mysqli_num_rows($datos) == 0) {
        echo "<p>No se encontraron registros.</p>";
    } else {

        echo '<div class="container">';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No.</th>';
        echo '<th>Num. Control</th>';
        echo '<th>Nombre</th>';
        echo '<th>Primer Apellido</th>';
        echo '<th>Segundo Apellido</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;

        while($fila = mysqli_fetch_assoc($datos)){
            $i++;
                printf( "<tr> <td>" . $i . "</td>
                              <td>".$fila['numControl']."</td>
                              <td>".$fila['nombre']."</td>
                              <td>".$fila['primerAp']."</td>
                              <td>".$fila['segundoAp']."</td>

                              <td> 
                                <button type='button' class='btn btn-primary btn-sm'
                                    data-toggle='modal' data-target='#miModal' data-nc='%s'> DETALLES </button> | 

                                <a href=\"formulario_cambios.php?nc=%s\" 
                                    class='btn btn-warning btn-sm'> MODIFICAR </a> | 
                                    
                                <a href=\"../backend/scripts/procesar_baja.php?nc=%s\" 
                                    class='btn btn-danger btn-sm'> ELIMINAR </a>
                              </td>
                          </tr>"

                 , $fila['numControl'], $fila['numControl'], $fila['numControl']);

        }
        $i = 0;

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

    }     

?>

<!-- Modal: nota el id="miModal" -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles</h5>
      </div>
        <div class="modal-body">
          <p><strong>Num. Control:</strong> <span id="modalNc"></span></p>
          <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
          <p><strong>Primer apellido:</strong> <span id="modalPrimerAp"></span></p>
          <p><strong>Segundo apellido:</strong> <span id="modalSegundoAp"></span></p>
          <p><strong>Fecha de nacimiento:</strong> <span id="modalFechaNac"></span></p>
          <p><strong>Semestre:</strong> <span id="modalSemestre"></span></p>
          <p><strong>Carrera:</strong> <span id="modalCarrera"></span></p>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#miModal').on('show.bs.modal', function (event) {
    var nc = $(event.relatedTarget).data('nc');

    $('#modalTitulo').text('Cargando...');
    $('#miModal span[id^="modal"]').text('');

    $.getJSON('../backend/scripts/cargar_datos.php', { nc: nc })
        .done(function (a) {
            $('#modalTitulo').text(a.nombre + ' ' + a.primerAp);
            $('#modalNc').text(a.numControl);
            $('#modalNombre').text(a.nombre);
            $('#modalPrimerAp').text(a.primerAp);
            $('#modalSegundoAp').text(a.segundoAp);
            $('#modalFechaNac').text(a.fechaNac);
            $('#modalSemestre').text(a.semestre);
            $('#modalCarrera').text(a.carrera);
        })
        .fail(function () {
            $('#modalTitulo').text('Error');
            $('#modalNombre').text('No se pudieron cargar los datos.');
        });
});
</script>

</body>
</html>