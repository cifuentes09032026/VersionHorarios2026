<?php 
include("../../confi/conexion.php");
 session_start();

  $correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../../horarios.php');
}

$ubs=$_GET['ubS'];
$nombreC=$_POST['nombreC'];
$Direc=$_POST['Direc'];
$phone=$_POST['phone'];

$query="UPDATE `sede` set `nombre_sede`='$nombreC', `direccion_sede`='$Direc', `telefono_sede`='$phone' where `id`='$ubs'";
 mysqli_query($conn,$query);
 echo "<script>
 window.location= '../../vista/show-sede.php?v=1';
</script>";  

 ?>
