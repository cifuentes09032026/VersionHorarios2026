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
$idpo=$_GET['ubP'];
$id_competencia=$_POST['id_competencias'];
$competencias_programa=$_POST['competencias'];
$fecha_inicio=$_POST['fecha_inicial'];
$fecha_fin=$_POST['fecha_fin'];
$instructor=$_POST['instructor'];

$queryInsertCode = "UPDATE competencias SET competencias = '$competencias_programa',
fecha_ini = '$fecha_inicio', fecha_fin = '$fecha_fin',
instructor = '$instructor' WHERE  id='$id_competencia'";

$resultado = mysqli_query($conn, $queryInsertCode);
header("location:../../vista/competencias-resultados.php?ubP=$idpo&v=1");

?>