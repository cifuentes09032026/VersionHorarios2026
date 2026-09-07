<?php

$pageTitle = 'Fichas';
include("parte_superior.php");
?> 
<div class="conteiner">

<br>
<a class="btn btn-success" href="horarios.php"> Regresar  
 </a>

 <a class="btn btn-success" href="crear/create-ficha.php"> Crear Ficha  
 </a>
 <a class="btn btn-success" href="crear/crear_trimestre.php"> Crear Trimestre  
 </a>
</div>


<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
        <!--Collapse_Ficha_Ficha secl-->
        <div id="accordion">
          <a type="button" class="btn btn-outline-secondary mt-4" href="fichas-activas-tabla.php">Consultar fichas activas</a>
          <div id="collapseOne" class="collapse show" data-parent="#accordion">
          <?php
            if (isset($_GET['v'])) {
              if ($_GET['v'] == 1) {
            ?>
                <div class="alert alert-success alert-dismissible fade show mt-4">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                  <strong>La ficha se actualizó correctamente</strong>
                </div>
            <?php
              } elseif($_GET['v']==2){
                ?>
                <div class="alert alert-danger alert-dismissible fade show mt-4">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                  <strong>Ficha sin horarios registrados</strong>
                </div>
                <?php
              }
            }
            ?>
            <div class="card-body">
              <?php
            $tablaf = "SELECT * FROM ficha,programa,nivel_forma,jornada 
            WHERE ficha.fc_id_programa = programa.id_program
            and ficha.fc_nivel = nivel_forma.id
            and ficha.fc_jornada = jornada.id ";
              $contf = mysqli_query($conn, $tablaf);
              ?>
              <div class="table-responsive">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Ficha</th>
                      <th>Nombre del programa</th>
                      <th>Nivel de formacion</th>
                      <th>Jornada </th>
                      <th>Trimestres</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($fcon = mysqli_fetch_assoc($contf)) {
                    ?>
                      <tr>
                        <td><?php echo $fcon['Nº ficha']; ?></td>
                        <td><?php echo $fcon["Nom_program"]; ?></td>
                        <td><?php echo $fcon["Nivel_for"]; ?></td>
                        <td><?php echo $fcon["tipo_jornada"]; ?></td>
                        <th class="d-flex justify-content-center"> <a href="./editar/update_trimestre.php?upfech=<?php echo $fcon["ID_F"] ?>"><button type="submit" class="btn btn-light btn-sm"><i class="fa-solid fa-calendar-days"></i></button></a></th>
                       <td>
    <div class="btn-group">

        <!-- Botón Horario -->
        <button class="btn btn-dark btn-sm px-3 py-1"
            onclick="window.open('horarios_ficha.php?ficha=<?php echo $fcon['ID_F']?>&pro=<?php echo $fcon['id_program']?>','_self')">
            Horario
        </button>

        <!-- Editar ficha -->
        <a href="editar/update-ficha.php?ubf=<?php echo $fcon['ID_F']; ?>"
           class="btn btn-success btn-sm px-2">
            <i class="bi-pencil-square"></i>
        </a>

        <!-- Eliminar ficha -->
        <a href="../controlador/FichaControllers/delete.php?eliF=<?php echo $fcon['ID_F']; ?>"
           class="btn btn-danger btn-sm px-2"
           onclick="return delete_('¿Está seguro de eliminar esta ficha?', 
           'Se eliminó la ficha exitosamente.');">
            <i class="bi-trash"></i>
        </a>

        <!-- Competencias y resultados -->
        <a href="competencias-resultados.php?ubP=<?php echo $fcon['ID_F']; ?>"
           class="btn btn-dark btn-sm px-3 py-1">
            Competencias y resultados
        </a>

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
</div>
</div>
<script src="js.js">
</script>

<?php
include("parte_inferior.php")
?>