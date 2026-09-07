<?php
$pageTitle = 'Editar ambiente';
include("../plantillas/parte_superior.php");
?>

<div class="content-wrapper">
  <div class="container">
    <br>
    <?php
    $idA = $_GET['ubA']; //id de la ambiente------------------------------------------------------

    $queryA = "SELECT * FROM `ambiente`,`sede` WHERE `id_A`='$idA' and `ambiente`.`id_sede`= `sede`.`id`";
    $result = mysqli_query($conn, $queryA);
    $rows = $result->fetch_array();
    ?>
    <div class="row" style="display: contents;">
      <div class="col-sm-8 mx-auto">
        <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
          <form action="../../controlador/AmbienteControllers/update.php?ubA=<?php echo $idA ?>" method="POST">
            <div class="form-group">
              <?php
              $sed = "SELECT * FROM sede";
              $conSD = mysqli_query($conn, $sed);
              ?>
              <label for="progC">Nombre de la sede:</label>
              <select class="form-control" id="progC" name="sed" required="">
                <option value="<?php echo $rows['id_sede'] ?>"><?php echo $rows['nombre_sede'] ?></option>
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
              <input type="text" class="mr-sm-2 form-control" value="<?php echo $rows['Nombre_ambiente'] ?>" placeholder="Digite el nombre del ambiente" name="nombre_ambiente" id="nomb" required="">
            </div>
            <div class="form-group">
              <label for="cap">Capacidad:</label>
              <input type="text" class="form-control" value="<?php echo $rows['Capacidad_ambiente'] ?>" placeholder="Digite la capacidad" name="capacidad" id="cap" required="">
            </div>
            <div class="form-group">
              <label for="equip">No de equipos :</label>
              <input type="number" class="mr-sm-2 form-control" value="<?php echo $rows['No_equipos'] ?>" placeholder="Digite el numero" name="No_de_equipos" id="equip" required="">
            </div>

            <div class="btn-group">
              <button type="button" class="btn btn-secondary" onclick="window.open('../show-ambiente.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
              <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="height: 370px;"></div>
<?php
include("../plantillas/parte_inferior.php");
?>
</body>

</html>