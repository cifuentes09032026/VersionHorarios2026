<?php
$pageTitle = 'Actualizar contraseña Usuario';
include("../plantillas/parte_superior.php");
?>
<div>
  <div class="content-wrapper">
    <div class="container">
      <br>
      <div class="row" style="display: contents;">
        <div class="col-sm-8 mx-auto">
          <div class="container border" style="padding:4%; background-color: #a2a1a5a8;">
            <form method="post" action="../../controlador/passwordControllers/password_validation.php" class="form-horizontal">
              <div class="form-group">
                <div class="form-group">
                  <label for="d_pwd">Digite su contraseña actual:</label>
                  <input type="password" class="form-control" placeholder="Digite la contraseña" name="D_pwd" id="d_pwd" required="">
                </div>
              </div>
              <button type="submit" class="btn btn-dark">Enviar</button>
            </form>
          </div>
          <?php
          if (isset($_GET['pwd'])) {
            $v_pwd = $_GET['pwd'];
            $cons_pwd = mysqli_query($conn, "SELECT * FROM instructor where ID = '$instru'");
            $row = mysqli_fetch_assoc($cons_pwd);
            if ($row['contrasena'] == $v_pwd) {
          ?>
              <br>
              <div class="container border" style="padding:4%; background-color: #a2a1a5a8;">
                <form method="post" action="../../controlador/passwordControllers/update.php" class="form-horizontal">
                  <div class="form-group">
                    <div class="form-group">
                      <label for="pwd">su nueva contraseña:</label>
                      <input type="password" class="form-control" placeholder="Digite la contraseña" name="contra" id="pwd" required="">
                    </div>
                    <div class="form-group">
                      <label for="pwd2">Confirme su nueva contraseña:</label>
                      <input type="password" class="form-control" placeholder="Confirmar contraseña" name="contra2" id="pwd2" required="">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-dark">Enviar</button>
                </form>
              </div>
          <?php
            }
          }
          ?>
          <!--alerta pwd-->

          <?php
          if (isset($_GET['pwd_x'])) {

            if ($_GET['pwd_x'] == '20123554_d') {
          ?><br>
              <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>La contraseña es incorrecta </strong>
              </div>
            <?php
            } elseif ($_GET['pwd_x'] == 'cons_not') {
            ?>
              <br>
              <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Las contraseñas no coinciden</strong>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="height: 620px;"></div>
<?php
include("../plantillas/parte_inferior.php");
?>