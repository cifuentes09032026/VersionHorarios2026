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

$id_competencia=$_GET['delete'];
$id=$_GET['ubP'];

$query="DELETE FROM competencias WHERE id ='$id_competencia'";
mysqli_query($conn,$query);
echo "<script>
window.location= '../../vista/competencias-resultados.php?ubP=$id';</script>";
 ?>