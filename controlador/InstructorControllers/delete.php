<?php 
session_start();
 $correo=$_SESSION['ema'];

if (!isset($correo)) {
        header("location:../../index.php");
 }
 $rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../../horarios.php');
}

include "../../confi/conexion.php";

$eliminar=$_GET['eli'];

$query="DELETE FROM instructor WHERE instructor.ID='$eliminar'";
mysqli_query($conn,$query);
echo "<script>
window.location= '../../vista/show-instructor.php';</script>";   
 ?>