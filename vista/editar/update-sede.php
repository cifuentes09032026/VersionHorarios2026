<?php
$pageTitle = 'Editar sede';
include("../plantillas/parte_superior.php");
?>

<div class="content-wrapper">
  <div class="container">
    <br>
    <?php
    $idsd = $_GET['ubS']; //id del sede-
    $query = "SELECT * FROM sede where `id`='$idsd'";
    $result = mysqli_query($conn, $query);
    $rows = $result->fetch_array();
    ?>
    <div class="row" style="display: contents;">
      <div class="col-sm-8 mx-auto">
        <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
          <form action="../../controlador/SedeControllers/update.php?ubS=<?php echo $idsd ?>" method="POST">
            <div class="form-group">
              <label for="nomC">Nombre sede:</label>
              <input type="text" class="mr-sm-2 form-control" value="<?php echo $rows['nombre_sede'] ?>" placeholder="Digite el nombre de la sede" name="nombreC" id="nomC" required="">
            </div>
            <div class="form-group">
              <label for="DS">Direccion sede:</label>
              <input type="text" class="form-control" value="<?php echo $rows['direccion_sede'] ?>" placeholder="Digite el la direccion de la sede" name="Direc" id="DS" required="">
            </div>
            <div class="form-group">
              <label for="tl">Telefono sede:</label>
              <input type="number" class="mr-sm-2 form-control" value="<?php echo $rows['telefono_sede'] ?>" placeholder="Digite el telefono" name="phone" id="tl" required="">
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-secondary" onclick="window.open('../show-sede.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
              <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="height: 460px;"></div>
<?php
include("../plantillas/parte_inferior.php");
?>
</body>
</html>