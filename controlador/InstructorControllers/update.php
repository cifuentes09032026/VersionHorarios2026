<?php 
include("../../confi/conexion.php");
 session_start();

  $correo=$_SESSION['ema'];
 
  
 if (!isset($correo)) {
    header("location:../../index.php");
 }
  


$nom=$_POST['nombre'];
$ape=$_POST['apellido'];
$horasins=$_POST['horas_inst'];
$rol=$_POST['rol'];
$ubd=$_GET['ubd'];




$query="UPDATE `instructor` set `Nombre`='$nom', `Apellido`='$ape', `horas_inst`='$horasins', `rol`='$rol' where `ID`='$ubd'";
mysqli_query($conn,$query);

if ($query) {
   echo "<script>
window.location= '../../vista/show-instructor.php?v=4';
</script>"; 
}

?>