<?php
$pageTitle = 'Sedes';
include("parte_superior.php");
?>

<head>
  <title>Sedes</title>
</head>

<br>
<div class="conteiner">

      <a class="btn btn-success" href="horarios.php"> Regresar  
       </a>

       <a class="btn btn-success" href="crear/create-sede.php"> Crear sede  
       </a>
		</div>
    
<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
        <?php
        $tablaS = "SELECT * FROM `sede`";
        $contS = mysqli_query($conn, $tablaS);
        ?>
        <div class="card-body">
         <?php
          if (isset($_GET['v'])) {
            if ($_GET['v'] == 1) {
          ?>
              <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <strong>La sede se actualizó correctamente</strong>
              </div>
          <?php
            }
          }
          ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped mt-4" style="text-align:center;">
            <thead>
              <tr>
                <th>Nombre sede</th>
                <th>Direccion Sede</th>
                <th>Telefono Sede</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($Scon = mysqli_fetch_assoc($contS)) {
              ?>
                <tr>

                  <td><?php echo $Scon['nombre_sede']; ?></td>
                  <td><?php echo $Scon["direccion_sede"]; ?></td>
                  <td><?php echo $Scon["telefono_sede"]; ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="editar/update-sede.php?ubS=<?php echo $Scon["id"] ?>"><button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i></button></a>
                      <a href="../controlador/SedeControllers/delete.php?eliS=<?php echo $Scon['id'] ?>"><button type="submit" class="btn btn-danger btn-sm" 
                      onclick="return delete_('¿Está seguro de eliminar esta sede?','Se eliminó la sede exitosamente.')"><i class="bi-trash"></i></button></a>
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
<?php
include("parte_inferior.php")
?>

<script src="js.js">
</script>