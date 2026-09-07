
<?php
$pageTitle = 'Instructores';
include("parte_superior.php");
?>
<br>


<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">

        <?php
        $tablai = "SELECT * FROM `instructor`,`roles` WHERE instructor.rol = roles.id_rol and instructor.ID > 1 ";
        $cont = mysqli_query($conn, $tablai);
        ?>
        
          
          <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>Horas faltantes</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($icon = mysqli_fetch_assoc($cont)) {

                  $hora_ins = $icon['ID'];
                  $resultsuma = mysqli_query($conn, "SELECT SUM(horas_instructor) as total FROM horarios,tb_trimestre WHERE horarios.id_trim_fch=tb_trimestre.id_T and horarios.instructor=$hora_ins and tb_trimestre.estatus_trim_H=0 ");
                  $horasins = mysqli_query($conn, "SELECT SUM(Numero_h) as totalinst FROM instructor,contrato WHERE instructor.ID=$hora_ins and contrato.id=instructor.horas_inst  ");
                  $rowssum = mysqli_fetch_array($resultsuma);
                  $sumah = $rowssum['total'];
                  $rowint = mysqli_fetch_array($horasins);
                  $suminr = $rowint['totalinst'];
                  $resp = $suminr - $sumah;

                ?>
                  <tr>

                    <td><?php echo $icon["Nombre"]; ?></td>
                    <td><?php echo $icon["Apellido"]; ?></td>
                    <td><?php echo $icon["email"]; ?></td>
                    <td><?php echo $resp ?></td>
                    <td>
                      <div class="btn-group">
                        <a href="admin/horarios_ins.php?instructor=<?php echo $icon["ID"]; ?>"><button type="submit" class="btn btn-dark btn-sm">Horario</button></a>
                     
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