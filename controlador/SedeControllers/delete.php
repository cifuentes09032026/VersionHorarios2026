<?php
include "../../confi/conexion.php";
session_start();
$correo=$_SESSION['ema'];


if (!isset($correo)) {
    
    header("location:../../index.php");
 }
 $rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../../horarios.php');
}

$eliminarS=$_GET['eliS'];

$query="DELETE FROM `sede` WHERE `id`='$eliminarS'";

mysqli_query($conn,$query);
echo "<script>window.location= '../../vista/show-sede.php';</script>";   
 ?>