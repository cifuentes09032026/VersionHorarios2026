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
$id_resultados=$_POST['id_resultados'];
$resultados=$_POST['resultados'];
$instructor=$_POST['instructor_resultados'];

$queryInsertCode = "UPDATE resultados SET resultados = '$resultados',
instructor_resultados = '$instructor' WHERE  id='$id_resultados'";

$resultado = mysqli_query($conn, $queryInsertCode);
header("location:../../vista/competencias-resultados.php?ubP=$idpo&v=1");

?>