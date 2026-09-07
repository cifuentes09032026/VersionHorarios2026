<?php
$pageTitle = 'Competencias y resultados';
include("parte_superior.php");
?>
<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
        <?php
        $progcon = $_GET['ubP'];
        $query = mysqli_query($conn, "SELECT * FROM ficha WHERE ID_F=$progcon");
        
        $row = mysqli_fetch_assoc($query);
        ?>
        <div class="card-body">
          <?php
          if (isset($_GET['v'])) {
            if ($_GET['v'] == 1) {
          ?>
              <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <strong>Las competencias se actualizaron correctamente</strong>
              </div>
          <?php
            }
          }
          ?>
          <a href="crear/create-competencias.php?ubP=<?php echo $progcon ?>" class="btn btn-success"> Crear competencias</a>
          <div class="table-responsive">
            <table class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Competencias</th>
                  <th>Fecha inicial</th>
                  <th>Fecha Final</th>
                  <th>Instructor</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $contprog = mysqli_query($conn, "SELECT * FROM competencias WHERE competencias.Ficha_id = $progcon");
                while ($row = mysqli_fetch_assoc($contprog)) { ?>
                <div class="form-group">
                  <form method="post" action="../controlador/FichaControllers/update_competencia.php?ubP=<?php echo $progcon ?>">
                    <tr>
                      <td><input class="form-control" type="number" name="id_competencias" style="display:none;" value="<?php echo $row['id']; ?>">
                        <input class="form-control" type="text" name="competencias" value="<?php echo $row["competencias"]; ?>">
                      </td>
                      <td><input class="form-control" type="text" name="fecha_inicial" value="<?php echo $row["fecha_ini"]; ?>"></td>
                      <td><input class="form-control" type="text" name="fecha_fin" value="<?php echo $row["fecha_fin"]; ?>"></td>
                      <td>
                        <select class="form-control" id="instructor" name="instructor">
                          <option value="<?php echo $row['instructor'] ?>"><?php echo $row['instructor'] ?></option>
                          
                              <?php
                              $instructor = mysqli_query($conn,"SELECT * FROM instructor WHERE instructor.ID > 1  ORDER BY instructor.Nombre ASC");
                              while ($ins = mysqli_fetch_array($instructor)) { ?>
                              <option value="<?php echo $ins["Nombre"]. " " . $ins['Apellido'] ?>"><?php echo $ins["Nombre"] . " " . $ins['Apellido'] ?></option><?php } ?>
                        </select>
                      </div>
            <div>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i></button>
                        </form>
                        <a href="../controlador/FichaControllers/delete_competencia.php?delete=<?php echo $row['id']; ?>&ubP=<?php echo $progcon?>">
                         <button type="submit" class="btn btn-danger btn-sm"  onclick="return delete_('¿Está seguro de eliminar esta competencia?','Se eliminó exitosamente.')"><i class="bi-trash"></i></button></a>
                      </td>
                    </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>

          <a href="crear/create-resultados.php?create=<?php echo $progcon ?>" class="btn btn-success"> Crear resultados</a>
          <div class="table-responsive">
            <table class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Resultados</th>
                  <th>Instructor</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $contprog = mysqli_query($conn, "SELECT * FROM resultados
                WHERE resultados.Fichas_id = $progcon");
                while ($row = mysqli_fetch_assoc($contprog)) {
                ?><div class="form-group">
                  <form method="post" action="../controlador/FichaControllers/update_resultados.php?ubP=<?php echo $progcon ?>">
                    <tr>
                      <td><input class="form-control" type="number" name="id_resultados" style="display:none;" value="<?php echo $row['id']; ?>">
                       <input class="form-control" type="text" name="resultados" value="<?php echo $row["resultados"]; ?>">
                      </td>
                      <td>
                      <select class="form-control" id="instructor" name="instructor_resultados">
                          <option value="<?php echo $row['instructor_resultados'] ?>"><?php echo $row['instructor_resultados'] ?></option>
                       
                              <?php
                              $instructor = mysqli_query($conn,"SELECT * FROM instructor ORDER BY instructor.Nombre ASC");
                              while ($ins = mysqli_fetch_array($instructor)) { ?>
                              <option value="<?php echo $ins["Nombre"]. " " . $ins['Apellido'] ?>"><?php echo $ins["Nombre"] . " " . $ins['Apellido'] ?></option><?php } ?>
                        </select>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i></button>
                        </form>
                        <a href="../controlador/FichaControllers/delete_resultado.php?delete=<?php echo $row['id']; ?>&ubP=<?php echo $progcon?>"> <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return delete_('¿Está seguro de eliminar este resultado?','Se eliminó exitosamente.')"><i class="bi-trash"></i></button></a>
                      </td>
                    </tr>
                  </div>
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