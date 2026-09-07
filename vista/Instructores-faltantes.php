<?php
$pageTitle = 'Instructores';
include("parte_superior.php");
?>
<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
      <a type="button" class="btn btn-outline-secondary mt-4" href="show-instructor.php">Atras</a>

        <?php
        $tablai = "SELECT * FROM `instructor`,`roles` WHERE instructor.rol = roles.id_rol and instructor.ID > 1 ";
        $cont = mysqli_query($conn, $tablai);
        ?>
        <div class="card-body">
          <?php
          if (isset($_GET['v'])) {
            if ($_GET['v'] == 4) {
          ?>
              <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <strong>El usuario se actualizó correctamente</strong>
              </div>
          <?php
            }
          }
          ?>
          <div class="table-responsive">
            <table id="table1"  class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Horas faltantes</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($icon = mysqli_fetch_assoc($cont)) {

                  $hora_ins = $icon['ID'];
                  $resultsuma = mysqli_query($conn, "SELECT SUM(horas_instructor) as total FROM horarios WHERE horarios.instructor=$hora_ins");
                  $horasins = mysqli_query($conn, "SELECT SUM(horas_inst) as totalinst FROM instructor  WHERE instructor.ID=$hora_ins");
                  $rowssum = mysqli_fetch_array($resultsuma);
                  $sumah = $rowssum['total'];
                  $rowint = mysqli_fetch_array($horasins);
                  $suminr = $rowint['totalinst'];
                  $resp = $suminr - $sumah;

                ?>
                  <tr>
                    <td><?php echo $resp ?></td>
                    <td><?php echo $icon["Nombre"]; ?></td>
                    <td><?php echo $icon["Apellido"]; ?></td>
                    <td><?php echo $icon["email"]; ?></td>
                    <td><?php echo $icon["rol"]; ?></td>
                    <td><center>
                      <div class="btn-group">
                        <a href="admin/horarios_ins.php?instructor=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-dark btn-sm">Horario</button></a>
                        <a href="/horarios/vista/editar/update-instructor.php?ubds=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i></button></a>
                        <a href="../controlador/InstructorControllers/delete.php?eli=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-danger btn-sm" onclick="return delete_('¿Está seguro de eliminar este instructor?',
                      'Se eliminó el instructor exitosamente.')"><i class="bi-trash"></i></button></a>
                      </div>
                      </center></td>
                  </tr>
                <?php
                }

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#table1').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );</script>

<script src="js.js"></script>
<?php
include("parte_inferior.php")
?>