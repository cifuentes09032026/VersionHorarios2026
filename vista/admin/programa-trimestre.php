<?php 
include ('../../controlador/conexion.php');
session_start();
$correo=$_SESSION['ema'];
$inst=$_SESSION['nam'];
 if (!isset($correo)) {
    header("location:../../index.php");
 }
 $rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../horarios.php');
 }
 if (isset($_GET['ficha'])) {
      
$id_ficha=$_GET['ficha'];
 $_SESSION['fh']=$id_ficha;//sesseion id ficha prar eliminar horario
 $title=mysqli_query($conn,"SELECT * FROM ficha WHERE ID_F ='$id_ficha'");
 $titles=mysqli_fetch_assoc($title);
}

if (isset($_GET['trims'])) {
  $_SESSION['trim']=$_GET['trims'];
}

?>

<?php 
include("plantilla.php");
?>

<div class="content-wrapper">
      <div class="container">                  
            <div class="collapse">
              <div class="container border" style="padding:4%; background-color: #a2a1a5a8;" >

                <form method="GET" class="form-horizontal">
                  <div class="form-group">
                    <select class="form-control" name="nivel_F" required>
                      <option value="">Selecione nivel programa </option>
                      <option value="Técnico">Técnico</option>
                      <option value="Tecnólogo">Tecnólogo</option>
                      <option value="Especialización">Especialización</option>                
                    </select><br>
                <select class="form-control" name="Trimestre" required>
                        <option value="">Seleccione el trimestre </option>
                        <option value="I Trimestre">I Trimestre</option>
                        <option value="II Trimestre">II Trimestre</option>
                        <option value="III Trimestre">III Trimestre</option> 
                        <option value="IV Trimestre">IV Trimestre</option>
                        <option value="V Trimestre">V Trimestre</option>
                        <option value="VI Trimestre">VI Trimestre</option>                    
                </select>
                  </div>
               
                  <button type="submit" class="btn btn-dark" href="ficha.php" >Enviar</button>
                </form>
              </div>
            </div>

    