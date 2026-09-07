<?php
$pageTitle = 'Programas';
include("parte_superior.php");
?>

<br>
<div class="conteiner">

      <a class="btn btn-success" href="horarios.php"> Regresar  
       </a>

       <a class="btn btn-success" href="crear/create-programa.php"> Crear Programa  
       </a>

       <a class="btn btn-success" href="crear/create-programas.php"> Subir Programas  
       </a>
		</div>
    


<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
        <?php
$contprog= mysqli_query($conn,"SELECT * FROM programa,nivel_forma 
where programa.nivel_form = nivel_forma.id   ");        ?>
        <div class="card-body">
        <?php
          if (isset($_GET['v'])) {
            if ($_GET['v'] == 1) {
          ?>
              <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <strong>El programa se actualizó correctamente</strong>
              </div>
          <?php
            }
          }
          ?>
          <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>Nombre del Programa</th>
                  <th>Nivel de formacion</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($progcon = mysqli_fetch_assoc($contprog)) {
                ?>
                  <tr>
                    <td><?php echo $progcon["Nom_program"]; ?></td>
                    
                    <td><?php echo $progcon["Nivel_for"]; ?></td>
                    <td>
                      <div class="btn-group">
                      
                        <a href="editar/update-programa.php?ubP=<?php echo $progcon["id_program"] ?>">
                          <button type="submit" class="btn btn-success btn-sm"><i class="bi-pencil-square"></i>
                          </button></a>
                          <a href="../controlador/ProgramaControllers/delete.php?eliP=<?php echo $progcon['id_program'] ?>"><button type="submit" class="btn btn-danger btn-sm" 
                            onclick="return delete_('¿Está seguro de eliminar este programa?','Se eliminó el programa exitosamente.')"><i class="bi-trash"></i></button></a>
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