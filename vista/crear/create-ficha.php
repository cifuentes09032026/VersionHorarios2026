<?php
$pageTitle = 'Registro de fichas';
include("../plantillas/parte_superior.php");
?>
<div> 
  <div class="row">
    <div class="col-sm-8 mx-auto">
      <div class="container border" style="padding:5%; background-color: #a2a1a5a8; ">
      <?php
      if (isset($_GET['vl'])) {

        if ($_GET['vl'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ficha registrada</strong>
          </div>
        <?php
        } elseif ($_GET['vl'] == 2) {
        ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>La ficha ya esta registrada.</strong>
          </div>
          <?php
        } elseif ($_GET['vl'] == 3) {
        ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>La ficha no.</strong>
          </div>
      <?php
        }
      }
      ?>
      
        <form action="../../controlador/FichaControllers/create.php" method="POST">
          <div class="form-group">
            <label for="fi">Numero de ficha:</label>
            <input type="number" max="9999999" class="mr-sm-2 form-control" placeholder="Ficha (Maximo 7 caracteres)" name="fich" id="fi" >
          </div>
          <div class="form-group">
            <label for="nop">Cantidad de aprendices:</label>
            <input type="number" class="form-control" placeholder="Cantidad de aprendices" name="can_apren" id="nop" >
          </div>

          <div class="form-group">
          <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Nombre instructor::</label>   
              <select class="form-control" id="ins" name="instructor" placeholder="">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
          </div>
          <div class="form-group">
          <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Nivel de ficha:</label>   
              <select class="form-control" id="nivel" name="nivel_prog" placeholder="">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id,Nivel_for FROM nivel_forma LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["Nivel_for"]; ?> </option>
            <?php }?>
            </select>
          </div>
          <div class="form-group">
          <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Jornada:</label>   
              <select class="form-control" id="jor" name="jornad">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id,tipo_jornada FROM jornada LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["tipo_jornada"]; ?> </option>
            <?php }?>
            </select>
          </div>
          <div class="form-group">
          <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Tipo de Formacion:</label>   
              <select class="form-control" id="tipf" name="tipof">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id_ty,Type_form FROM tipo_form LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id_ty"]; ?>"> <?php echo $filas["Type_form"]; ?> </optiotipo_jornadan>
            <?php }?>
            </select>
            
          </div>
          <div class="form-group">
            <?php
            $prog = "SELECT * FROM programa";
            $cons = mysqli_query($conn, $prog);
            ?>
            <label for="progC">Nombre del programa:</label>
            <select class="form-control" id="progC" name="program">
              <option value="">Seleccione</option>
              <?php
              while ($cod_p = mysqli_fetch_assoc($cons)) {
              ?>
                <option value="<?php echo $cod_p['id_program'] ?>"><?php echo $cod_p['Nom_program']?> </option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="f_i">Fecha de inicio de etapa lectiva:</label>
            <input type="date" class="form-control" name="date_i" id="f_i" >
          </div>
          <div class="form-group">
            <label for="f_f">Fecha de fin de etapa lectiva:</label>
            <input type="date" class="form-control" name="date_f" id="f_f" >
          </div>
          <div class="form-group">
            <label for="f_i">Fecha de inicio de etapa productiva:</label>
            <input type="date" class="form-control" name="inicio_prod" id="f_i" >
          </div>
          <div class="form-group">
            <label for="f_f">Fecha de fin de etapa productiva:</label>
            <input type="date" class="form-control" name="fin_prod" id="f_f" >
          </div>
          <button type="button" class="btn btn-secondary" onclick="window.open('../show-ficha.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
      </div>
      
    </div>
  </div>
</div>
<?php
include("../plantillas/parte_inferior.php")
?>