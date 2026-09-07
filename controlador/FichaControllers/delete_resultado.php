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

$id_resultado=$_GET['delete'];
$id=$_GET['ubP'];

$query="DELETE FROM resultados WHERE id ='$id_resultado'";
mysqli_query($conn,$query);
echo "<script>window.location= '../../vista/competencias-resultados.php?ubP=$id';</script>";
 ?>