<?php
include '../../confi/conexion.php';
$con_ins = mysqli_query($conn, "SELECT * FROM instructor  WHERE ID='$id_ins'");
  $rowins = mysqli_fetch_array($con_ins);
?>
<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" action="../../controlador/guardar-instructor.php?instructor=<?php echo $id_ins;  ?>">
          <div class="form-group">
            <label for="ins">Instructor:</label> 
            <input type="hidden" name="ins"> <?php echo $rowins['Nombre'] ." ". $rowins['Apellido']  ?>

            <br>
            <label for="">Ficha:</label>
            <?php
            $ficha_sql = "SELECT * FROM ficha";
            $consulA1 = mysqli_query($conn, $ficha_sql);
            ?>
            <select class="form-control" id="ho" name="f_c" required>
              <option value="0">Seleccionar Ficha</option>
              <?php
              while ($rowficha = mysqli_fetch_assoc($consulA1)) {
              ?>
                <option value="<?php echo $rowficha['ID_F'] ?>"><?php echo $rowficha['Nº ficha'] ?></option><br><br>
              <?php
              }
              ?>
            </select>
            <div class="container form-check"> 
            <label for="hour">Dia:</label>
              <div class="row justify-content-around">
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkdia2[1]" value="1">Luneees</input><br>
                  <input class="form-check-input" type="checkbox" name="checkdia2[2]" value="2">Martes</input><br>
                  <input class="form-check-input" type="checkbox" name="checkdia2[3]" value="3">Miercoles</input><br>
                </div>
                <div class="col-4">
                  <input class="form-check-input" type="checkbox" name="checkdia2[4]" value="4">Jueves</input><br>
                  <input class="form-check-input" type="checkbox" name="checkdia2[5]" value="5">Viernes</input><br>
                  <input class="form-check-input" type="checkbox" name="checkdia2[6]" value="6">Sabado</input><br>
                </div>
              </div>
            </div><br>
            <div class="container">
              <label for="hour">Hora:</label><br>
              <div class="row justify-content-around">
                  <div class="col-4">
                    <input class="form-check-input" type="checkbox" name="checkhora2[1]" value="1">06:00 - 07:40</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[2]" value="2">08:00 - 09:40</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[3]" value="3">10:00 - 11:40</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[4]" value="4">12:00 - 13:40</input><br>
                  </div>
                  <div class="col-4">
                    <input class="form-check-input" type="checkbox" name="checkhora2[5]" value="5">14:20 - 16:00</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[6]" value="6">16:20 - 18:00</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[7]" value="7">18:15 - 19:45</input><br>
                    <input class="form-check-input" type="checkbox" name="checkhora2[8]" value="8">20:00 - 21:40</input>
                  </div>
              </div>
            </div>
            <br>
            <label for="ho">Ambiente:</label>
            <?php
            $amb = "SELECT * FROM ambiente WHERE ambiente.id_A > 1 ORDER BY ambiente.Nombre_ambiente ASC";
            $consulA = mysqli_query($conn, $amb);
            ?>
            <select class="form-control" id="ho" name="idAB" required>
              <option value="0">Seleccionar Ambiente</option>
              <?php
              while ($ambt = mysqli_fetch_assoc($consulA)) {
              ?>
                <option value="<?php echo $ambt['id_A'] ?>"><?php echo $ambt['Nombre_ambiente'] ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            
            
            <br>
            <label class="control-label" for="descripcion" >Descripción: </label>
            <input type="text" class="form-control" name="descrip" placeholder="Cursos Virtuales" required><br>
            <label class="control-label" for="Obse">Observaciones:</label>
            <textarea name="observaciones" id="" cols="3" rows="2" class="form-control" required></textarea>
            <br>
            
            <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>    
              <?php 
              
              ?>        
              
            <?php ?>
            </select>
             <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Periodo Curzado:</label>   
              <select class="form-control" id="cur" name="perd_cur" placeholder="">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select><br>
            <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Año Curzado:</label>   
              <select class="form-control" id="yea" name="year_cur" placeholder="">
              <option value="">Seleccionar</option>
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>


          </div>

            <div class="modal-footer">
              <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi-arrow-left"></i>Cancelar</button>
                <button type="submit" class="btn btn-success">Crear</button>
                
              </div>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>