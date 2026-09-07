<?php
$pageTitle = 'Crear competencias';
include("../plantillas/parte_superior.php");
$crearCompetencia = $_GET['ubP'];
?>
<?php
$query = mysqli_query($conn, "SELECT * FROM ficha WHERE ID_F = $crearCompetencia");
$row = mysqli_fetch_assoc($query);


if (isset($_POST["enviar"])) {

  require_once("excel/excelcompetencias.php");
  

  $archivo = $_FILES["archivo"]["name"];
  $archivocopiado = $_FILES["archivo"]["tmp_name"];
  $archivoguardado = "copia_".$archivo;

  if(copy($archivocopiado ,$archivoguardado)){
    
  }else{
    echo " no se copio";
  }

  if (file_exists($archivoguardado)) {
      $fp = fopen($archivoguardado,"r");
      $rows = 0;
      while ($datos = fgetcsv($fp , 10000 , ";")) {
        $rows++;

        if($rows > 1){
          //echo $datos[0]." " .$datos[1]." " .$datos[2]." " .$datos[3] ."<br/>";

        $resultado = insertar_datos($datos[0],$datos[1],$datos[2],$datos[3],$datos);
        if ($resultado) {
          echo'
            <script>
              alert("Competencias registradas");
              window.location = "../show-ficha.php";
            </script>';
        }else{
          echo " no se inserto<br/>";
        }

        }
        
        
      }


  }else{echo"No existe el archivo";}

}


?>
<div class="row">
  <div class="container border" style="padding:5%; background-color: #a2a1a5a8; ">
    <form action="create-competencias.php?ubP=<?php echo $crearCompetencia; ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nom_prog">Ficha: <?php echo $row['Nº ficha'] ?> </label>
      </div>
      <div class="form-group">
        <label for="formFile" class="form-label">Subir Excel (.csv) con las competencias para la ficha <?php echo $row['Nº ficha'] ?></label><br>
        <input type="file" name="archivo" required/><br><br>
        <button type="button" class="btn btn-secondary" onclick="window.open('../show-ficha.php','_Self')"><i class="bi-arrow-left"></i>Atrás</button>
        <input type="submit" value="Subir Excel" class="btn btn-success" name="enviar">
      </div>
    </form>
  </div>
</div>
<script src="js.js"></script>
<?php
include("../plantillas/parte_inferior.php")
?>