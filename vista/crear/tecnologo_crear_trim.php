<?php
$pageTitle = 'Registro de trimestres';
include("../plantillas/parte_superior.php");
?>


<div>
  <div class="row">
    <div class="col-sm-10 mx-auto">
      <div class="container border" style="padding:3%; background-color: #a2a1a5a8;">
        <?php
        $conFT = mysqli_query($conn, "SELECT * FROM ficha,programa 
        WHERE ficha.fc_id_programa=programa.id_program AND ficha.estatus_trim=0");
        ?>
        <form action="../../controlador/trimestreControllers/createtecnologo.php" method="POST" style="padding-left:5%;">
          <div class="form-group">
            <h4>Ficha:</h4>
            <select name="ficha_fecha" class="form-control">
                    <option value="">Seleccionar</option>
                    <?php
                    $ficha = mysqli_query($conn, "SELECT * FROM ficha WHERE fc_nivel LIKE '2';");
                    while ($n_ficha = mysqli_fetch_array($ficha)) { ?>
                      <option value="<?php echo $n_ficha["ID_F"] ?>"><?php echo $n_ficha['Nº ficha'] ?></option><?php } ?>
                  </select>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Trimestre</th>
                <th scope="col">Fecha de inicio</th>
                <th scope="col">Fecha final</th>
                <th scope="col">Instructor</th>
                <th scope="col">Periodos</th>
                <th scope="col">Año</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">I</th>
                <td><input type="date" class="form-control" name="date_i_I" id="f_i_t_I"></td>
                <td><input type="date" class="form-control" name="date_f_I" id="f_f_t_I"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_1" placeholder="seleccionar" required="">

              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                 <td>
                 <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_1" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 6";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_1" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>
                
              </tr>

              <tr>
                <th scope="row">II</th>
                <td><input type="date" class="form-control" name="date_i_II" id="f_i_t_II"></td>
                <td><input type="date" class="form-control" name="date_f_II" id="f_f_t_II" ></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_2" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_2" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                  
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_2" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>


              </tr>

              <tr>
                <th scope="row">III</th>
                <td><input type="date" class="form-control" name="date_i_III" id="f_i_t_III"></td>
                <td><input type="date" class="form-control" name="date_f_III" id="f_f_t_III"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_3" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_3" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_3" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>

              </tr>

              <tr>
                <th scope="row">IV</th>
                <td><input type="date" class="form-control" name="date_i_IV" id="f_i_t_IV"></td>
                <td><input type="date" class="form-control" name="date_f_IV" id="f_f_t_IV"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_4" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_4" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_4" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select> 
                </td>

              </tr>

              <tr>
                <th scope="row">V</th>
                <td><input type="date" class="form-control" name="date_i_V" id="f_i_t_V"></td>
                <td><input type="date" class="form-control" name="date_f_V" id="f_f_t_V"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_5" placeholder="seleccionar" required="">
             
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_5" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_5" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>
              </tr>

              <tr>
                <th scope="row">VI</th>
                <td><input type="date" class="form-control" name="date_i_VI" id="f_i_t_VI"></td>
                <td><input type="date" class="form-control" name="date_f_VI" id="f_f_t_VI"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_6" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_6" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_6" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>


              </tr>

              <tr>
                <th scope="row">VII</th>
                <td><input type="date" class="form-control" name="date_i_VII" id="f_i_t_VII"></td>
                <td><input type="date" class="form-control" name="date_f_VII" id="f_f_t_VII"></td>
                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ins" name="instructor_7" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT ID,Nombre,Apellido FROM instructor ORDER BY instructor.Nombre ASC LIMIT 100 ";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["ID"]; ?>"> <?php echo $filas["Nombre"]; ?> <?php echo $filas["Apellido"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="ped" name="periodo_7" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,periodo FROM periodo LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["periodo"]; ?> </option>
            <?php }?>
            </select>
                </td>

                <td>
                <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <select class="form-control" id="yea" name="año_7" placeholder="seleccionar" required="">
              <?php 
              $sql = "SELECT id,time_tit FROM año LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["time_tit"]; ?> </option>
            <?php }?>
            </select>
                </td>
                
              </tr>


            </tbody>
          </table>
          <button type="submit" class="btn btn-dark">Registrar</button>
        </form>
        <br><a href="./crear_trimestre.php" style="margin-left:40px ;"><button class="btn btn-dark">Atras</button></a>
      </div>
      <?php
      if (isset($_GET['vtf'])) {

        if ($_GET['vtf'] == 1) {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Fechas registradas</strong>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>
</div>
<div style="height: 80px;"></div>
<?php
include("../plantillas/parte_inferior.php")
?>