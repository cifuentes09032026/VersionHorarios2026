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

$eliminarP=$_GET['eliP'];

$query="DELETE FROM `programa` WHERE `id_program`='$eliminarP'";

mysqli_query($conn,$query);
echo "<script>window.location= '../../vista/show-programa.php';</script>";   
 ?>