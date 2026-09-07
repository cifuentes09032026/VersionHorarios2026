<?php
$pageTitle = 'Editar programa';
include("../plantillas/parte_superior.php");
?>

<div class="content-wrapper">
  <div class="container">
    <br>
    <?php
    $idpg = $_GET['ubP']; //id del Programa------------------------------------------------------
 
    $query = "SELECT * FROM programa where `id_program`='$idpg'";
    $result = mysqli_query($conn, $query);
    $rows = $result->fetch_array();
    ?>
    <div class="row" style="display: contents;">
      <div class="col-sm-8 mx-auto">
        <div class="container border" style="padding:4%; background-color: #a2a1a5a8; ">
          <form action="../../controlador/ProgramaControllers/update.php?ubPO=<?php echo $idpg ?>" method="POST">
            <div class="form-group">
              <label for="nom_prog">Nombre del programa:</label>
              <input type="text" class="form-control" value="<?php echo $rows['Nom_program'] ?>" placeholder="Digite el nombre del programa" name="nomp" id="nom_prog" required="">
            </div>
            <div class="form-group">
              <label for="nivl">Nivel del programa:</label>
              <select class="form-control" id="nivl" name="nivel_prog" required="">
                <option value="<?php echo $rows['nivel_form'] ?>"><?php echo $rows['nivel_form'] ?></option>
                <option value="Técnico">Técnico</option>
                <option value="Tecnólogo">Tecnólogo</option>
                <option value="Especialización">Especialización</option>
              </select>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-secondary" onclick="window.open('../show-programa.php','_Self')"> <i class="bi-arrow-left"></i>Atrás</button>
              <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="height: 540px;"></div>
<?php
include("../plantillas/parte_inferior.php");
?>
<script src="js.js"></script>
<script>
   // agregar registro
   $("#addRow").click(function() {
    var html = '';
    html += '<div id="inputFormRow">';
    html += '<div class="input-group mb-3">';
    html += '<input type="text" name="competencias[]" class="form-control m-input" autocomplete="off">';
    html += '<div class="input-group-append ml-2">';
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
</body>

</html>