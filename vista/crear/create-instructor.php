<?php
$pageTitle = 'Registro de usuarios';
include("../plantillas/parte_superior.php");
?>
<div>
  <div class="row">
    <div class="col-sm-8 mx-auto">
      <div class="container border" style="padding:5%; background-color: #a2a1a5a8; ">

        <form action="../../controlador/InstructorControllers/create.php" method="POST">
          <div class="form-group">
            <label for="nom">Nombre:</label>
            <input type="text" class="mr-sm-2 form-control " placeholder="Digite el nombre" name="nombre" id="nom" required="">
          </div>
          <div class="form-group">
            <label for="apel">Apellido:</label>
            <input type="text" class="form-control" placeholder="Digite el Apellido" name="apellido" id="apel" required="">
          </div>
          <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="mr-sm-2 form-control " placeholder="Digite el Email" name="correo" id="email" required="">
          </div>
          <div class="form-group">
          <label for="roles">Rol del Instructor:</label>
            <select class="form-control" id="horasi" name="horas_inst" required>
              <option value="">Seleccione el tipo de contrato</option>
              <option value="2">Planta</option>
              <option value="1">Termino fijo</option>
            </select>
          </div>
          <div class="form-group">
            <label for="pwd">Contraseña:</label>
            <input type="password" class="form-control" placeholder="Digite la contraseña" name="contra" id="pwd" required="">
          </div>
          <div class="form-group">
            <label for="pwd2">Confirmar Contraseña:</label>
            <input type="password" class="form-control" placeholder="Confirmar contraseña" name="contra2" id="pwd2" required="">
          </div>
          <div class="form-group">
            <label for="roles">Rol del Instructor:</label>
            <select class="form-control" id="roles" name="rol" required>
              <option value="">Seleccione el Rol</option>
              <option value="2">Instructor</option>
              <option value="1">Administrador</option>
            </select>
          </div>
          <button type="button" class="btn btn-secondary" onclick="window.open('../show-instructor.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
      </div>
            <?php
      if (isset($_GET['v'])) {

        if ($_GET['v'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
            <strong>Usuario registrado</strong>
          </div>
        <?php
        } elseif ($_GET['v'] == 2) {
        ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>El correo ya está registrado, intente con otro correo.</strong>
          </div>
        <?php
        } elseif ($_GET['v'] == 3) {
        ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>La contraseña no coincide</strong>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>
<div style="height: 110px;"></div>
<?php
include("../plantillas/parte_inferior.php")
?>