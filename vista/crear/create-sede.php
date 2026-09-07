<?php
$pageTitle = 'Registro de sedes';
include("../plantillas/parte_superior.php");
?>
<div>
  <div class="row" style="display: contents;">
    <div class="col-sm-8 mx-auto">
      <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
        <form action="../../controlador/SedeControllers/create.php" method="POST">
          <div class="form-group">
            <label for="nomC">Nombre sede:</label>
            <input type="text" class="mr-sm-2 form-control " placeholder="Digite el nombre de la sede" name="nombreC" id="nomC" required="">
          </div>
          <div class="form-group">
            <label for="DS">Direccion sede:</label>
            <input type="text" class="form-control" placeholder="Digite el la direccion de la sede" name="Direc" id="DS" required="">
          </div>
          <div class="form-group">
            <label for="tl">Telefono sede:</label>
            <input type="number" class="mr-sm-2 form-control " placeholder="Digite el telefono" name="phone" id="tl" required="">
          </div>
          <button type="button" class="btn btn-secondary" onclick="window.open('../show-sede.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
      </div>
      <?php
      if (isset($_GET['vs'])) {

        if ($_GET['vs'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sede registrada</strong>
          </div>
        <?php
        } elseif ($_GET['vs'] == 2) {
        ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>La direccion y sede ya se encuentran registradas</strong>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>
</div>
<div style="height: 470px;"></div>
<?php
include("../plantillas/parte_inferior.php")
?>