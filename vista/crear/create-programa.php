<?php
$pageTitle = 'Registro de programa';
include("../plantillas/parte_superior.php");
?>
<div class="row">
  <div class="container border" style="padding:3%; background-color: #a2a1a5a8;">
    <form action="../../controlador/ProgramaControllers/create.php" method="POST">
      <div class="form-group">
        <label for="nom_prog">Nombre del programa:</label>
        <input type="text" class="form-control" placeholder="Digite el nombre del programa" name="nomp" id="nom_prog">
      </div>
      <div class="form-group">

      <?php 
              $Conexion = new mysqli('localhost','root','','beta_horarios'); ?>               
              <label for ="sell">Nivel de programa:</label>   
              <select class="form-control" id="nivl" name="nivel_prog">
              <?php 
              $sql = "SELECT id,Nivel_for FROM nivel_forma LIMIT 10";
              $Resultado = mysqli_query($Conexion,$sql) or die("Error en la tabla". mysqli_error($Conexion));
              while ($filas = mysqli_fetch_assoc($Resultado)){
              ?>        
              <option value="<?php echo $filas["id"]; ?>"> <?php echo $filas["Nivel_for"]; ?> </option>
            <?php }?>
            </select>
       
      </div>
      <button type="button" class="btn btn-secondary" onclick="window.open('../show-programa.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
        <button type="submit" class="btn btn-dark">Registrar</button>
    </form>
  </div>
</div>
<?php
if (isset($_GET['vp'])) {

  if ($_GET['vp'] == 1) {
?>
    <div class="alert alert-success alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Programa registrado</strong>
    </div>
  <?php
  } elseif ($_GET['vp'] == 2) {
  ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>El Programa ya se encuentra registrado</strong>
    </div>
<?php
  }
}
?>
</div>
</div>
<script src="js.js"></script>
<script>
  // agregar registro
  $("#addRow-resultados").click(function() {
    var html = '';
    html += '<h6>Agregar más resultados:</h6>';
    html += '<div id="inputFormRow-resultados">';
    html += '<div class="form-group mt-2">';
    html += '<textarea name="resultados[]" class="form-control" placeholder="Digite el resultado"></textarea>';
    html += '</div>';

    html += '<div class="form-group">';
    html += '<input type="text" name="instructor-resultados[]" placeholder="Instructor encargado del resultado" class="form-control">';
    html += '</div>';
    html += '<div class="input-group-append">';
    html += '<button id="removeRow-resultados" type="button" class="btn btn-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>';
    html += '</div>';
    html += '</div>';

    $('#newRow-resultados').append(html);
  });

  // borrar registro
  $(document).on('click', '#removeRow-resultados', function() {
    $(this).closest('#inputFormRow-resultados').remove();
  });


    // agregar registro
    $("#addRow").click(function() {
    var html = '';
    html += '<h6>Agregar más competencias:</h6>';
    html += '<div id="inputFormRow">';
    html += '<div class="form-group mb-3">';
    html += '<textarea name="competencias[]" class="form-control" placeholder="Digite la competencia"></textarea>';
    html += '</div>';

    html += '<div class="form-row mb-3">';
    html += '<div class="form-group col-md-4">';
    html += '<input type="date" name="fecha_inicio[]" class="form-control">';
    html += '</div>';

    html += '<div class="form-group col-md-4">';
    html += '<input type="date" name="fecha_fin[]" class="form-control">';
    html += '</div>';

    html += '<div class="form-group col-md-4">';
    html += '<input type="text" name="instructor[]" class="form-control">';
    html += '</div>';
    html += '<div class="input-group-append">';
    html += '<button id="removeRow" type="button" class="btn btn-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>';
    html += '</div>';
    html += '</div>';

    $('#newRow').append(html);
  });

  // borrar registro
  $(document).on('click', '#removeRow', function() {
    $(this).closest('#inputFormRow').remove();
  });
</script>
<div style="height: 550px;"></div>
<?php
include("../plantillas/parte_inferior.php")
?>