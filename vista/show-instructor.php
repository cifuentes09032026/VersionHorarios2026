<?php
$pageTitle = 'Instructores';
include("parte_superior.php");
?>
<br>

<div class="conteiner">

      <a class="btn btn-success" href="horarios.php"> Regresar  
       </a>

       <a class="btn btn-success" href="crear/create-instructor.php"> Crear Instructor  
       </a>

      <a class="btn btn-success" href="crear/create-instructores.php"> Subir Instructores  
       </a>
		</div>
    


<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
      <a type="button" class="btn btn-outline-secondary mt-4" href="Instructores-faltantes.php">Instructores faltantes por completar horario</a>

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
            <table id="table" class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Horas faltantes</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($icon = mysqli_fetch_assoc($cont)) {

                  $hora_ins = $icon['ID'];

// 🔹 Total de horas asignadas en el horario (formación titulada)
$resultsuma = mysqli_query($conn, "
  SELECT COALESCE(SUM(horas_instructor), 0) AS total 
  FROM horarios 
  INNER JOIN tb_trimestre ON horarios.id_trim_fch = tb_trimestre.id_T 
  WHERE horarios.instructor = $hora_ins 
    AND tb_trimestre.estatus_trim_H = 0
");
$rowssum = mysqli_fetch_assoc($resultsuma);
$horas_titulada = $rowssum['total'] ?? 0;

// 🔹 Total de horas extra registradas por el instructor
$result_extras = mysqli_query($conn, "
  SELECT COALESCE(SUM(horas), 0) AS total_extras 
  FROM horas_extra 
  WHERE instructor_id = $hora_ins
");
$row_extras = mysqli_fetch_assoc($result_extras);
$horas_extras = $row_extras['total_extras'] ?? 0;

// 🔹 Total de horas del contrato (asignadas al instructor)
$horasins = mysqli_query($conn, "
  SELECT c.Numero_h 
  FROM instructor i
  INNER JOIN contrato c ON i.horas_inst = c.id
  WHERE i.ID = $hora_ins
");
$rowint = mysqli_fetch_assoc($horasins);
$horas_contrato = $rowint['Numero_h'] ?? 0;

// 🔹 Calcular horas faltantes correctamente
// Las 10.5 NO se restan del cupo de 32 horas

$total_usadas = $horas_titulada + $horas_extras;

$resp = $horas_contrato - $total_usadas;

if ($resp < 0) {
    $resp = 0;
}



                ?>
                  <tr>

                    <td><?php echo $icon["Nombre"]; ?></td>
                    <td><?php echo $icon["Apellido"]; ?></td>
                    <td><?php echo $icon["email"]; ?></td>
                    <td><?php echo $icon["rol"]; ?></td>
                    <td><?php echo $resp ?></td>
                    <td>
                      <div class="btn-group">
                        <a href="admin/horarios_ins.php?instructor=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-dark btn-sm">Horario</button></a>
                        <a href="editar/update-instructor.php?ubds=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i></button></a>
                        <a href="../controlador/InstructorControllers/delete.php?eli=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-danger btn-sm" onclick="return delete_('¿Está seguro de eliminar este instructor?',
                      'Se eliminó el instructor exitosamente.')"><i class="bi-trash"></i></button></a>
                      </div>
                    </td>
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
<script src="js.js"></script>
<?php
include("parte_inferior.php")
?>