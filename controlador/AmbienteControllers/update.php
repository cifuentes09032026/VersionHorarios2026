<?php
include ('../../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../index.php");
}
$rol=$_SESSION['rol'];
 if ($rol==2) {
   header('location:../horarios.php');
}
 
$sed=$_POST['sed'];
$nom_A=$_POST['nombre_ambiente'];
$capA=$_POST['capacidad'];
$N_E=$_POST['No_de_equipos'];
$uba=$_GET['ubA'];

$query="UPDATE `ambiente` set `Nombre_ambiente`='$nom_A', `Capacidad_ambiente`='$capA', `No_equipos`='$N_E',`id_sede`='$sed' where `id_A`='$uba' ";
mysqli_query($conn, $query); 

echo "<script>
window.location= '../../vista/show-ambiente.php?v=1';
</script>"; 
?>