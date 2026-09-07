<?php
$pageTitle = 'Registro de trimestres';
include("../plantillas/parte_superior.php");
?>
<div>
  <div class="row">
    <div class="col-sm-10 mx-auto">
      <div class="container border" style="padding:3%; background-color: #a2a1a5a8; ">
        <form action="../controlador/trimestreControllers/create.php" method="POST" style="padding-left:5%;">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Trimestres</th>
                <th scope="col">Fecha de inicio</th>
                <th scope="col">Fecha final</th>
                <th scope="col">Instructor</th>
                <th scope="col">Año</th>
                <th scope="col">Periodo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">I</th>
                <td><input type="date" class="form-control" name="date_i_I" id="f_i_t_I" required></td>
                <td><input type="date" class="form-control" name="date_f_I" id="f_f_t_I" required></td>
                <td><input type="number" value="1" name="valor_I" hidden></td>
                
              </tr>

              <tr>
                <th scope="row">II</th>
                <td><input type="date" class="form-control" name="date_i_II" id="f_i_t_II" required></td>
                <td><input type="date" class="form-control" name="date_f_II" id="f_f_t_II" required></td>
                <td><input type="number" value="2" name="valor_II" hidden></td>
              </tr>

              <tr>
                <th scope="row">III</th>
                <td><input type="date" class="form-control" name="date_i_III" id="f_i_t_III" required></td>
                <td><input type="date" class="form-control" name="date_f_III" id="f_f_t_III" required></td>
                <td><input type="number" value="3" name="valor_III" hidden></td>
              </tr>

              <tr>
                <th scope="row">IV</th>
                <td><input type="date" class="form-control" name="date_i_IV" id="f_i_t_IV" required></td>
                <td><input type="date" class="form-control" name="date_f_IV" id="f_f_t_IV" required></td>
                <td><input type="number" value="4" name="valor_IV" hidden></td>
              </tr>
              
            </tbody>
          </table>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
      </div>
      <?php
      if (isset($_GET['vtf'])) {

        if ($_GET['vtf'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Fechas registradas</strong>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>
</div>
<?php
include("../plantillas/parte_inferior.php")
?>