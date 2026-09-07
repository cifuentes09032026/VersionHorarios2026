<?php

include "../../confi/conexion.php";

session_start();
$correo=$_SESSION['ema'];
if (!isset($correo)) {
    
    header("location:../index.php");
 }
 $rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../horarios.php');
}

$eliminarA=$_GET['eliA'];

$query="DELETE FROM `ambiente` WHERE `id_A`='$eliminarA'";

mysqli_query($conn,$query);
echo "<script>window.location= '../../vista/show-ambiente.php';</script>";   
 ?>