<?php
$pageTitle = 'Editar ficha';
include("../plantillas/parte_superior.php");
?>
<div class="content-wrapper">
  <div class="container">
    <br>
    <?php
    $idfc = $_GET['ubf']; //id de la ficha------------------------------------------------------

    $queryf = "SELECT * FROM ficha,programa where `ID_F`='$idfc' and ficha.fc_id_programa=programa.id_program";
    $result = mysqli_query($conn, $queryf);
    $rows = $result->fetch_array();
    ?>

    
    <div class="row" style="display: contents;">
      <div class="col-sm-8 mx-auto">
        <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
          <form action="../../controlador/FichaControllers/update.php?ubf=<?php echo $idfc ?>" method="POST">
            <div class="form-group">
              <label for="fi">Numero de ficha:</label>
              <input type="number" class="mr-sm-2 form-control" value="<?php echo $rows['Nº ficha'] ?>" placeholder="Ficha" name="fich" id="fich">
                        </div>
            <div class="form-group">
              <label for="nop">Cantidad de aprendices:</label>
              <input type="number" class="form-control" value="<?php echo $rows['fc_cant_aprend'] ?>" placeholder="Cantidad de aprendices" name="can_apren" id="nop" required="">
            </div> 
            <div class="form-group">
            <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Nombre instructor:</label>   
              <select class="form-control" id="ins" name="instructor" placeholder="">
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
              <label for ="sell">Jornada:</label>   
              <select class="form-control" id="jor" name="jornad">
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
              <select class="form-control" id="progC" name="program" required="">
                <option value="<?php echo $rows['id_program'] ?>"><?php echo $rows['Nom_program'] ?></option>
                <?php
                while ($cod_p = mysqli_fetch_assoc($cons)) {
                ?>
                  <option value="<?php echo $cod_p['id_program'] ?>"><?php echo $cod_p['Nom_program'] ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="f_i">Fecha inicio de etapa lectiva:</label>
              <input type="date" class="form-control" value="<?php echo $rows['fic_date_I'] ?>" name="date_i" id="f_i" required="">
            </div>
            <div class="form-group">
              <label for="f_f">Fecha Fin de etapa lectiva:</label>
              <input type="date" class="form-control" value="<?php echo $rows['fic_date_F'] ?>" name="date_f" id="f_f" required="">
            </div>
            <div class="form-group">
            <label for="f_i">Fecha de inicio de etapa productiva:</label>
            <input type="date" class="form-control" value="<?php echo $rows['inicio_prod'] ?>" name="inicio_prod" id="inicio_prod" required="">
          </div>
          <div class="form-group">
            <label for="f_f">Fecha de fin de etapa productiva:</label>
            <input type="date" class="form-control" value="<?php echo $rows['fin_prod'] ?>" name="fin_prod" id="fin_prod" required="">
          </div>
            <div class="btn-group">
            <button type="button" class="btn btn-secondary" onclick="window.open('../show-ficha.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>             
             <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include("../plantillas/parte_inferior.php");
?>
</body>

</html>