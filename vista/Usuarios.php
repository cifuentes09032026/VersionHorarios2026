
<?php
$pageTitle = 'Usuarios';
include("parte_superior.php");
?>
<div>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="container">
    

        <?php
        $tablai = "SELECT * FROM instructor ";
        $cont = mysqli_query($conn, $tablai);
        ?>
        <div class="card-body">
          <?php
          if (isset($_GET['v'])) {
            if ($_GET['v'] == 4) {
          ?>
              <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <strong>El usuario se actualizó correctamente</strong>
              </div>
          <?php
            }
          }
          ?>
          <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped mt-4">
              <thead>
                <tr>
                  <th>ID</th>  
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Contraseña</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($fila = mysqli_fetch_assoc($cont)) {

               

                ?>
                  <tr>
                    <td><?php echo $fila["ID"]; ?></td>
                    <td><?php echo $fila["Nombre"]; ?></td>
                    <td><?php echo $fila["email"]; ?></td>
                    <td><?php echo $fila["contrasena"]; ?></td>
                    
                    <td>
                      
                      <a class="btn btn-success" href="editar/editar_usuarios.php?id=<?php echo $fila['ID']?> ">
                      Editar </a>

                      <a class="btn btn-danger" href="#?id=<?php echo $fila['ID']?>">
                      Desactivar</a>
                      </div>
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
