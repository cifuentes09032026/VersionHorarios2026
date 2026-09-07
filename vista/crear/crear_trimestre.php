<?php
$pageTitle = 'Crear Trimestre';
include("../plantillas/parte_superior.php");
?>


<div>
  <div class="row">
    <div class="col-sm-10 mx-auto">
      <div class="container border" style="padding:3%; background-color: #a2a1a5a8;">
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
      <h4>Seleccione el nivel del programa: </h4><br>
      <a href="tecnico_crear_trim.php"><button type="button" class="btn btn-secondary btn-block" style="cursor: pointer;">Técnico</button></a><br>
      <a href="tecnologo_crear_trim.php"><button type="button" class="btn btn-secondary btn-block" style="cursor: pointer;">Tecnólogo</button></a>
      <br>
      <button type="button" class="btn btn-secondary" onclick="window.open('../show-ficha.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
      </div>
    </div>
  </div>
</div>



<div style="height: 550px;"></div>

<?php
include("../plantillas/parte_inferior.php")
?>