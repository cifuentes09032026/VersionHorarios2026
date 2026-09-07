<?php
$pageTitle = 'Registro ambientes';
include("../plantillas/parte_superior.php");
?>

<div>
  <div class="row" style="display: contents;">
    <div class="col-sm-8 mx-auto mt-4">
      <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
        <form action="../../controlador/AmbienteControllers/create.php" method="POST">
          <div class="form-group">
            <?php
            $sed = "SELECT * FROM sede";
            $conSD = mysqli_query($conn, $sed);
            ?>
            <label for="sede_">Nombre de la sede:</label>
            <select class="form-control" id="sede_" name="sed" required>
              <option value="">Seleccione</option>
              <?php
              while ($codSD = mysqli_fetch_assoc($conSD)) {
              ?>
                <option value="<?php echo $codSD['id'] ?>"><?php echo $codSD['nombre_sede'] ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nomb">Nombre ambiente:</label>
            <input type="text" class="mr-sm-2 form-control " placeholder="Digite el nombre del ambiente" name="nombre_ambiente" id="nomb" required="">
          </div>
          <div class="form-group">
            <label for="cap">Capacidad:</label>
            <input type="text" class="form-control" placeholder="Digite la capacidad" name="capacidad" id="cap" required="">
          </div>
          <div class="form-group">
            <label for="equip">No de equipos :</label>
            <input type="number" class="mr-sm-2 form-control " placeholder="Digite el numero" name="No_de_equipos" id="equip" required="">
          </div>
          <button type="button" class="btn btn-secondary" onclick="window.open('../show-ambiente.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
      </div>
      <?php
      if (isset($_GET['va'])) {

        if ($_GET['va'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show mt-3">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ambiente registrado</strong>
          </div>
        <?php
        } elseif ($_GET['va'] == 2) {
        ?>
          <div class="alert alert-danger alert-dismissible fade show mt-3">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>El ambiente de la sede ya se encuentran registrados.</strong>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>
</div>
<div style="height: 360px;"></div>
<?php
include("../plantillas/parte_inferior.php")
?>